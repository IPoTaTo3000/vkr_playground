<?php
    session_start();

    function checkUser($login, $password = "") {
        $connect = mysqli_connect('MySQL-8.2', 'root', '', 'playground');
        if (!$connect) {
            die("Ошибка подключения: " . mysqli_connect_error());
        }
    
        $query = "SELECT * FROM users WHERE login = ?";
        $statement = $connect->prepare($query);
        $statement->bind_param('s', $login);
        $statement->execute();
        $result = $statement->get_result();
    
        if ($result->num_rows === 1) {
            // Если передан пароль, проверяем его
            if (!empty($password)) {
                $row = $result->fetch_assoc();
                $hashedPassword = $row['password'];
    
                if (password_verify($password, $hashedPassword)) {
                    return true;
                }
            } else {
                return true; // Если пароль не передан, просто возвращаем true
            }
        }
    
        return false;
    }

    if (isset($_COOKIE['remember_user'])) {
        $remember_user = $_COOKIE['remember_user'];

        if (checkUser($remember_user, "")) {
            $_SESSION['user'] = $remember_user;
            header('Location: index.php');
            exit();
        } else {
            setcookie('remember_user', '', time() - 3600, '/');
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $login = $_POST['login'];
        $password = $_POST['password'];

        if (!empty($login) && !empty($password)) {
            if (checkUser($login, $password)) {
                $_SESSION['user'] = $login;

                if (isset($_POST['remember-me'])) {
                    $remember_me = true;
                    setcookie('remember_user', $login, time() + (7 * 24 * 60 * 60), '/');
                } else {
                    setcookie('remember_user', '', time() - 3600, '/');
                }

                header('Location: index.php');
                exit();
            } else {
                $_SESSION['log_fail'] = 'Неправильный логин или пароль';
                header('Location: login.php');
                exit();
            }
        } else {
            $_SESSION['log_fail'] = 'Введите логин и пароль';
            header('Location: login.php');
            exit();
        }
    }
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-Moz-Is-Generator" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <link rel="stylesheet" href="../styles/reg-login-style.css">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <style>
    .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
    }

    @media (min-width: 768px) {
        .bd-placeholder-img-lg {
            font-size: 3.5rem;
        }
    }
    </style>
</head>

<body class="text-center">
    <?php session_start(); ?>

    <main class="form-signin">
        <form action="singin.php" method="post" class="post-form">
            <img class="mb-4" src="../images/logo.png" alt="" width="100" height="100">
            <h1 class="h3 mb-3 fw-normal">Личный кабинет</h1>

            <div class="form-floating">
                <input type="text" name="login" placeholder="Имя пользователя" class="form-control" id="floatingInput">
                <label for="floatingInput">Имя пользователя</label>
            </div>
            <div class="form-floating">
                <input type="password" name="password" placeholder="Пароль" class="form-control" id="floatingPassword">
                <label for="floatingPassword">Пароль</label>
            </div>
            <div class="checkbox mb-3">
                <label>
                    <input type="checkbox" name="remember-me" value="1"> Запомнить меня
                </label>
            </div>
            <button class="w-100 mb-3 btn btn-lg btn-primary" type="submit">Войти</button>
            <div class="row">
                    <a style="text-decoration: none;" href="registerpage.php">Регистрация</a>
                </div>
            <p class="mt-5 mb-3 text-muted">&copy; 2024</p>
        </form>
    </main>
</body>
</html>