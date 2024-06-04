<?php
$connect = mysqli_connect('MySQL-8.2', 'root', '', 'playground');
//адрес сервера, имя пользователя, пароль, имя базы данных
if ($connect == false){
    print("Ошибка: Невозможно подключиться к MySQL " . mysqli_connect_error());
}
