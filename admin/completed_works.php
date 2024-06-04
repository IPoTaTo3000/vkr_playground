<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['login'] !== 'admin') {
    header('Location: ../profile/login.php');
    exit();
}
// Подключение к базе данных
require_once("../db+php/connect.php");

// Получение всех заявок со статусом "in progress"
$offer_query = "SELECT * FROM offer WHERE status_p = 'in progress'";
$offer_result = mysqli_query($connect, $offer_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администрирование</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<style>
    header {
        background-color: #f2f2f2;
        color: #333;
        text-align: right;
        padding: 10px 0;
    }
    footer {
        background-color: #f2f2f2;
        color: #333;
        text-align: center;
        padding: 10px 0;
        position: fixed;
        bottom: 0;
        width: 100%;
    }
</style>
<body>
    <header>
    <?php
    // Проверяем, есть ли пользователь вошедший в систему, и отображаем его имя
    if (isset($_SESSION['user']) && isset($_SESSION['user']['login'])) {
        echo "ADMIN ";
        echo '<button class="btn mb-2 me-3 btn-primary ms-2" onclick="location.href=\'mainadmin.php\'">Назад</button>';
        echo '<button class="btn mb-2 me-3 btn-danger ms-2" onclick="location.href=\'../index.php?logout=true\'">Выход</button>';
    } else {
        echo "Добро пожаловать!";
    }
    ?>
    </header>
    <div class="container">
        <h1>Заявки в процессе выполнения</h1>
        <form action="../scrypts/save_completed_works.php" method="post">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Дата</th>
                        <th>Описание</th>
                        <th>Работа</th>
                        <th>Исполнитель</th>
                        <th>Отметить как выполненную</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    while ($row = mysqli_fetch_assoc($offer_result)) {
                        // Получаем данные о работе и исполнителе по их ID
                        $work_id = $row['id_work'];
                        $worker_id = $row['id_worker'];

                        // Запросы к таблицам work и worker
                        $work_query = "SELECT * FROM work WHERE id_work = '$work_id'";
                        $worker_query = "SELECT * FROM worker WHERE id_worker = '$worker_id'";

                        $work_result = mysqli_query($connect, $work_query);
                        $worker_result = mysqli_query($connect, $worker_query);

                        // Получаем данные о работе и исполнителе
                        $work_data = mysqli_fetch_assoc($work_result);
                        $worker_data = mysqli_fetch_assoc($worker_result);

                        echo "<tr>";
                        echo "<td>{$row['id_offer']}</td>";
                        echo "<td>{$row['date_p']}</td>";
                        echo "<td>{$row['discription_p']}</td>";
                        echo "<td>{$work_data['Name']}</td>"; // Отображаем название работы
                        echo "<td>{$worker_data['Company_name']}</td>"; // Отображаем название исполнителя
                        echo "<td><input type='checkbox' name='completed[]' value='{$row['id_offer']}'></td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
    <footer>
        &copy; 2024 Все права защищены. Powered by: @alex.anfimov
    </footer>
</body>
</html>