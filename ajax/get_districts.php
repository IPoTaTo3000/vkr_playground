<?php
// Подключение к базе данных
$servername = "MySQL-8.2"; // Имя сервера базы данных
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль базы данных
$dbname = "Playground"; // Имя базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка соединения
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Получение значения города из AJAX запроса
$city = $_POST['city'];

// Запрос для получения районов выбранного города
$district_query = "SELECT DISTINCT district FROM Location WHERE city = '$city'";
$district_result = $conn->query($district_query);

// Формирование HTML-кода для выпадающего списка районов
$options = "<option value=''>Выберите район</option>";
while ($row = $district_result->fetch_assoc()) {
    $options .= "<option value='" . $row['district'] . "'>" . $row['district'] . "</option>";
}

// Вывод HTML-кода для обновления выпадающего списка районов в форме
echo $options;

// Закрытие соединения с базой данных
$conn->close();
?>