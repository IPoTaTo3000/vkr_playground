<?php
session_start();

// Уничтожаем сессию
session_unset();
session_destroy();

// Перенаправляем пользователя на страницу входа или на любую другую страницу, где он сможет продолжить работу
header('Location: index.php');
exit();
?>