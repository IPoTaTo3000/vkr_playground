<?php
session_start();

// Проверяем, авторизован ли пользователь с логином admin
if (!isset($_SESSION['user']) || $_SESSION['user']['login'] !== 'admin') {
    // Если пользователь не авторизован или не является администратором, перенаправляем его на страницу входа
    header('Location: ../profile/login.php');
    exit();
}

// Подключение к базе данных
require_once("../db+php/connect.php");

// Проверяем, была ли отправлена форма методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['completed'])) {
    // Получаем список выполненных заявок из формы
    $completed_requests = $_POST['completed'];

    // Перебираем выполненные заявки
    foreach ($completed_requests as $request_id) {
        // Обновляем статус заявки в таблице offer на "completed"
        $update_query = "UPDATE offer SET status_p = 'completed' WHERE id_offer = ?";
        $update_statement = mysqli_prepare($connect, $update_query);
        mysqli_stmt_bind_param($update_statement, "i", $request_id);
        mysqli_stmt_execute($update_statement);

        // Получаем данные о заявке
        $request_query = "SELECT * FROM offer WHERE id_offer = ?";
        $request_statement = mysqli_prepare($connect, $request_query);
        mysqli_stmt_bind_param($request_statement, "i", $request_id);
        mysqli_stmt_execute($request_statement);
        $request_result = mysqli_stmt_get_result($request_statement);
        $request_data = mysqli_fetch_assoc($request_result);

        // Вставляем выполненную заявку в таблицу completed_works
        $insert_query = "INSERT INTO completed_works (Date, id_offer, id_work, id_worker) VALUES (?, ?, ?, ?)";
        $insert_statement = mysqli_prepare($connect, $insert_query);
        mysqli_stmt_bind_param($insert_statement, "siii", $request_data['date_p'], $request_data['id_offer'], $request_data['id_work'], $request_data['id_worker']);
        mysqli_stmt_execute($insert_statement);

        mysqli_stmt_close($update_statement);
        mysqli_stmt_close($request_statement);
        mysqli_stmt_close($insert_statement);
    }

    // Перенаправляем обратно на страницу администрирования после завершения обработки
    header('Location: ../admin/completed_works.php');
    exit();
} else {
    // Если форма не была отправлена методом POST, перенаправляем обратно на страницу администрирования
    header('Location: ../admin/completed_works.php');
    exit();
}
?>