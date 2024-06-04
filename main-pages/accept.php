<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Заявка принята</title>
    <link rel="stylesheet" href="../styles/accept-style.css">
</head>
<body>
    <header>
        <?php
        session_start();
        // Проверяем, есть ли пользователь вошедший в систему, и отображаем его имя
        if (isset($_SESSION['user']) && isset($_SESSION['user']['login'])) {
            echo "Твоя заявка уже обрабатывается, " . htmlspecialchars($_SESSION['user']['login']) . "!";
        } else {
            echo "Добро пожаловать!";
        }
        ?>
    </header>

    <div class="container">
        <div class="message">
            Спасибо! Ваша заявка принята!
        </div>
        <div class="link">
            <a href="../index.php">На главную</a>
        </div>
    </div>

    <footer>
        &copy; 2024 Все права защищены.
    </footer>
</body>
</html>