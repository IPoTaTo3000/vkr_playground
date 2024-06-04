<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['login'] !== 'admin') {
    header('Location: ../profile/login.php');
    exit();
}
// Подключение к базе данных
require_once("../db+php/connect.php");
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
    .admin-buttons {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 70vh;
    }
    .admin-button {
        width: 300px;
        height: 100px;
        margin: 20px;
        font-size: 1.5rem;
    }
</style>
<body>
    <header>
    <?php
    // Проверяем, есть ли пользователь вошедший в систему, и отображаем его имя
    if (isset($_SESSION['user']) && isset($_SESSION['user']['login'])) {
        echo "ADMIN ";
        echo '<button class="btn mb-2 me-3 btn-danger ms-2" onclick="location.href=\'../index.php?logout=true\'">Выход</button>';
    } else {
        echo "Добро пожаловать!";
    }
    ?>
    </header>
    <div class="container admin-buttons">
        <button class="btn btn-primary admin-button" onclick="location.href='administration.php'">Назначение исполнителя</button>
        <button class="btn btn-secondary admin-button" onclick="location.href='completed_works.php'">Выполненные работы</button>
        <button class="btn btn-primary admin-button" onclick="location.href='archive.php'">Архив</button>
    </div>
    <footer>
        &copy; 2024 Все права защищены. Powered by: @alex.anfimov
    </footer>
</body>
</html>