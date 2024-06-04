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

// Проверка, была ли отправлена форма методом POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Проверка наличия данных о работе и исполнителе для каждой заявки
    if (isset($_POST['work']) && isset($_POST['worker'])) {
        // Получение данных о работе и исполнителе для каждой заявки
        $works = $_POST['work'];
        $workers = $_POST['worker'];

        // Перебор данных о работе и исполнителе для каждой заявки
        foreach ($works as $request_id => $work_id) {
            // Проверяем, были ли выбраны значения из выпадающих списков
            if (!empty($work_id) && !empty($workers[$request_id])) {
                $worker_id = $workers[$request_id];

                // Обновляем статус заявки в таблице offer на "in progress"
                $update_query = "UPDATE offer SET status_p = 'in progress', id_work = ?, id_worker = ? WHERE id_offer = ?";
                $update_statement = mysqli_prepare($connect, $update_query);
                mysqli_stmt_bind_param($update_statement, "iii", $work_id, $worker_id, $request_id);
                mysqli_stmt_execute($update_statement);
            }
        }
        
        // Закрываем подготовленные запросы, если они были созданы
        if (isset($update_statement)) {
            mysqli_stmt_close($update_statement);
        }

        // Перенаправляем обратно на страницу администрирования после завершения обработки
        header('Location: ../admin/administration.php');
        exit();
    } else {
        // Если данные о работе и/или исполнителе не были отправлены, перенаправляем обратно на страницу администрирования
        header('Location: ../admin/administration.php');
        exit();
    }
} else {
    // Если форма не была отправлена методом POST, перенаправляем обратно на страницу администрирования
    header('Location: ../admin/administration.php');
    exit();
}
?>