<?php
session_start();
require_once("../db+php/connect.php");
$connect = mysqli_connect('MySQL-8.2', 'root', '', 'playground');
if (!$connect) {
    die("Ошибка подключения: " . mysqli_connect_error());
}

$login = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['login']), ENT_QUOTES, 'UTF-8');
$pass = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['password']), ENT_QUOTES, 'UTF-8');
$phone = htmlspecialchars(mysqli_real_escape_string($connect, $_POST['Phone_number']), ENT_QUOTES, 'UTF-8');

if (empty($phone) || empty($login) || empty($pass)) {
    $_SESSION['reg_message'] = "Пожалуйста, заполните все поля";
    header('Location: registerpage.php');
    exit();
} else {
    $checkQuery = "SELECT * FROM Users WHERE `login` = '$login'";
    $checkResult = mysqli_query($connect, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['reg_message'] = "Данный логин уже занят. Пожалуйста, выберите другой логин.";
        header('Location: registerpage.php');
        exit();
    } else {
        mysqli_query($connect, "INSERT INTO Users (`Phone_number`, `login`, `password`) VALUES ('$phone', '$login', '$pass')");
        $all_info = mysqli_fetch_assoc(mysqli_query($connect, "SELECT * FROM `Users` WHERE `login` = '$login'"));//all info
        $_SESSION['Users'] = ["all" => $all_info];
        header('Location: ../index.php');
    }
}
?>