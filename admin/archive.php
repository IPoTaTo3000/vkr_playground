<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['login'] !== 'admin') {
    header('Location: ../profile/login.php');
    exit();
}
// Подключение к базе данных
require_once("../db+php/connect.php");

// Получение всех выполненных заявок
$completed_query = "SELECT offer.*, users.login AS user_login FROM offer INNER JOIN users ON offer.id_user = users.id_user WHERE offer.status_p = 'completed'";
$completed_result = mysqli_query($connect, $completed_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Архив</title>
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
        <h1>Архив заявок</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Номер заявки</th>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th>Описание</th>
                    <th>Работа</th>
                    <th>Исполнитель</th>
                    <th>Пользователь</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($row = mysqli_fetch_assoc($completed_result)) {
                    echo "<tr>";
                    echo "<td>{$row['id_offer']}</td>";
                    echo "<td>{$row['date_p']}</td>";
                    echo "<td>{$row['status_p']}</td>";
                    echo "<td>{$row['discription_p']}</td>";
                    echo "<td>{$row['id_work']}</td>";
                    echo "<td>{$row['id_worker']}</td>";
                    echo "<td>{$row['user_login']}</td>";
                    echo "</tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
    <footer>
        &copy; 2024 Все права защищены. Powered by: @alex.anfimov
    </footer>
</body>
</html>