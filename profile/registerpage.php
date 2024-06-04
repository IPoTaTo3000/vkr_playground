<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="X-Moz-Is-Generator" content="true">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registration</title>
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
    <?php session_start()?>
    <main class="form-signin">
            <form action="regin.php" method="POST" class="post-form">
                <img class="mb-4" src="../images/logo.png" alt="" width="100" height="100">
                <h1 class="h3 mb-3 fw-normal">Регистрация</h1>
                <!-- <div class="form-floating">
                <input name="name" type="text" maxlength="30" placeholder="Имя" required  class="form-control" id="floatingInput">
                <label for="floatingInput">Имя</label>
                </div> -->
                <div class="form-floating">
                <input name="Phone_number" type="tel" maxlength="15" placeholder="Номер телефона" required  class="form-control" id="floatingInput">
                <label for="floatingInput">Номер телефона</label>
                </div>

                <div class="form-floating">
                <input name="login" type="text" maxlength="45" placeholder="Имя пользователя" required  class="form-control" id="floatingInput">
                <label for="floatingInput">Логин</label>
                </div>
                <div class="form-floating  mb-4">
                <input name="password" type="password" maxlength="45" placeholder="Пароль" required  class="form-control" id="floatingPassword">
                <label for="floatingPassword">Пароль</label>
                </div>
                <button class="w-100 mb-3 btn btn-lg btn-primary" type="submit">Зарегистрироваться</button>
                <div class="row">
                    <a style="text-decoration: none;" href="login.php">Войти</a>
                </div>
                <p class="mt-3 mb-3 text-muted">&copy; 2024</p>
            </form>
        <?php 
        if (isset($_SESSION['reg_message'])) {
            echo '<div align="center" style="margin-bottom:15px;">' . $_SESSION['reg_message'] . '</div>';
            unset($_SESSION['reg_message']);
        }?>
    </main>
</body>
</html> 