<?php
session_start();

// Подключаем файл connect.php
require_once('../db+php/connect.php');

// Проверка, залогинен ли пользователь
if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id_user'])) {
    // Если пользователь не залогинен, перенаправляем его на страницу логина
    header('Location: ../profile/login.php');
    exit();
}

// Получение ID текущего пользователя
$user_id = $_SESSION['user']['id_user'];

// Функция для получения информации о пользователе из базы данных
function getUserData($connect, $user_id) {
    $sql = "SELECT * FROM Users WHERE id_user = $user_id";
    $result = mysqli_query($connect, $sql);
    return mysqli_fetch_assoc($result);
}

// Инициализация переменных для сообщений
$success_message = '';
$error_message = '';

// Обработка формы обновления профиля
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = mysqli_real_escape_string($connect, $_POST['name']);
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $phone_number = mysqli_real_escape_string($connect, $_POST['phone_number']);

    // Проверка длины полей
    if (strlen($name) > 255) {
        $error_message = 'Имя не должно превышать 255 символов.';
    } elseif (strlen($email) > 255) {
        $error_message = 'Email не должен превышать 255 символов.';
    } elseif (strlen($phone_number) > 20) {
        $error_message = 'Номер телефона не должен превышать 20 символов.';
    } else {
        // Обновление данных пользователя в базе данных
        $update_sql = "UPDATE Users SET Name = '$name', Email = '$email', Phone_number = '$phone_number' WHERE id_user = $user_id";
        try {
            if (mysqli_query($connect, $update_sql)) {
                // Обновляем информацию о пользователе в сессии
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['phone_number'] = $phone_number;

                // Перезагружаем данные пользователя из базы данных
                $user = getUserData($connect, $user_id);
                $success_message = "Профиль успешно обновлен.";
            } else {
                throw new mysqli_sql_exception("Ошибка при обновлении профиля: " . mysqli_error($connect));
            }
        } catch (mysqli_sql_exception $e) {
            $error_message = $e->getMessage();
        }
    }
} else {
    // Получение информации о пользователе из базы данных при первой загрузке страницы
    $user = getUserData($connect, $user_id);
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Мой профиль</title>
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
            echo "Ваш профиль, " . htmlspecialchars($_SESSION['user']['login']) . "!";
            echo '<button class="btn mb-2 me-3 btn-primary ms-2" onclick="location.href=\'../index.php\'">На главную</button>';
        } else {
            echo "Добро пожаловать!";
        }
        ?>
    </header>
    <div class="container">
        <h2>Мой профиль</h2>
        <form action="profile.php" method="POST">
            <?php if ($success_message): ?>
                <div class="alert alert-success">
                    <?php echo $success_message; ?>
                </div>
            <?php elseif ($error_message): ?>
                <div class="alert alert-danger">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <div class="mb-3">
                <label for="name" class="form-label">Имя</label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo htmlspecialchars($user['Name'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user['Email'] ?? ''); ?>">
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Номер телефона</label>
                <input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo htmlspecialchars($user['Phone_number'] ?? ''); ?>">
            </div>
            <button type="submit" class="btn btn-primary">Сохранить изменения</button>
        </form>
    </div>
    <footer>
        &copy; 2024 Все права защищены. Powered by: @alex.anfimov
    </footer>
</body>
</html>