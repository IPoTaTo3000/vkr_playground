<?php
session_start();

// Проверка, был ли выполнен выход
if (isset($_GET['logout'])) {
    // Разлогинивание пользователя и перенаправление на главную страницу
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit(); 
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администрирование</title>
    <link rel="stylesheet" href="styles/index-style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
</style>
<body>
    <header>
    <?php
    // Проверяем, есть ли пользователь вошедший в систему, и отображаем его имя
    if (isset($_SESSION['user']) && isset($_SESSION['user']['login'])) {
        $login = $_SESSION['user']['login'];
        echo "Здравствуйте, " . htmlspecialchars($_SESSION['user']['login']) . "!";
        echo '<button class="btn mb-2 me-3 btn-primary ms-2" onclick="location.href=\'main-pages/my_requests.php\'">Посмотреть мои заявки</button>';
        echo '<button class="btn mb-2 me-3 btn-primary ms-2" onclick="location.href=\'main-pages/profile.php\'">Профиль</button>';
        echo '<button class="btn mb-2 me-3 btn-danger ms-2" onclick="location.href=\'index.php?logout=true\'">Выход</button>';

    } else {
        echo "Здравствуйте, чтобы сообщить о проблеме пожалуйста войдите в свой профиль.";
        echo '<button class="btn mb-2 me-3 btn-primary ms-2" onclick="location.href=\'profile/login.php\'">Войти</button>';
        echo '<button class="btn mb-2 me-3 btn-primary ms-2" onclick="location.href=\'profile/registerpage.php\'">Регистрация</button>';
    }
    ?>
    </header>
    <div class="container">
    <?php
            if (isset($_SESSION['user']) && isset($_SESSION['user']['login'])) {
                echo '<button class="button2" onclick="location.href=\'main-pages/process_order.php\'">Сообщить о проблеме</button>';
            } else {
                echo '<button class="button2" onclick="location.href=\'profile/login.php\'">Сообщить о проблеме</button>';
            }
        ?>
    </div>
    <footer>
        &copy; 2024 Все права защищены. Powered by: @alex.anfimov
    </footer>
</body>
</html>