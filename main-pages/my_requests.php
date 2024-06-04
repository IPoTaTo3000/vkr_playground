<?php
session_start();

// Подключаем файл connect.php
require_once('../db+php/connect.php');

// Проверка, залогинен ли пользователь
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_user'])) {
    // Если пользователь не залогинен, перенаправляем его на страницу логина
    header('Location: login.php');
    exit();
}

// Получение ID текущего пользователя
$user_id = $_SESSION['user']['id_user'];

// Получение заявок пользователя из базы данных
$sql = "SELECT * FROM offer WHERE id_user = $user_id";
$result = mysqli_query($connect, $sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мои заявки</title>
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
    session_start();
    // Проверяем, есть ли пользователь вошедший в систему, и отображаем его имя
    if (isset($_SESSION['user']) && isset($_SESSION['user']['login'])) {
        echo "Это все ваши заявки, " . htmlspecialchars($_SESSION['user']['login']) . "!";
        echo '<button class="btn mb-2 me-3 btn-primary ms-2" onclick="location.href=\'../index.php\'">На главную</button>';
    } else {
        echo "Добро пожаловать!";
    }
    ?>
    </header>
    <div class="container">
        <h1>Мои заявки</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Дата</th>
                    <th>Статус</th>
                    <th>Описание</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (mysqli_num_rows($result) > 0) {
                    // Выводим данные заявок
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row["date_p"] . "</td>";
                        echo "<td>" . $row["status_p"] . "</td>";
                        echo "<td>" . $row["discription_p"] . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>У вас пока нет заявок</td></tr>";
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