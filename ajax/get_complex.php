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

// Получение значения района из AJAX запроса
$district = $_POST['district'];

// Запрос для получения жилых комплексов выбранного района
$complex_query = "SELECT DISTINCT residential_complex FROM Location WHERE district = '$district'";
$complex_result = $conn->query($complex_query);

// Формирование HTML-кода для выпадающего списка жилых комплексов
$options = "<option value=''>Выберите жилой комплекс</option>";
while ($row = $complex_result->fetch_assoc()) {
    $options .= "<option value='" . $row['residential_complex'] . "'>" . $row['residential_complex'] . "</option>";
}

// Вывод HTML-кода для обновления выпадающего списка жилых комплексов в форме
echo $options;

// Закрытие соединения с базой данных
$conn->close();
?>