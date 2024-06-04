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

// Получение значения идентификатора детской площадки из AJAX запроса
$playground_id = $_POST['playground_id'];

// Запрос для получения информации о детской площадке
$info_query = "SELECT Coating, Age, Function_p, photo_url, Safety, Infrastructure, Construction_date, Expiry_date, Maintenance_date, Additional_facilities FROM Playground WHERE id_playground = '$playground_id'";
$info_result = $conn->query($info_query);

// Проверка наличия данных
if ($info_result->num_rows > 0) {
    // Получение данных о детской площадке
    $row = $info_result->fetch_assoc();
    $coating = $row['Coating'];
    $age = $row['Age'];
    $function = $row['Function_p'];
    $photo_url = $row['photo_url'];
    $safety = $row['Safety'];
    $infrastructure = $row['Infrastructure'];
    $construction_date = $row['Construction_date'];
    $expiry_date = $row['Expiry_date'];
    $maintenance_date = $row['Maintenance_date'];
    $additional_facilities = $row['Additional_facilities'];
    
    // Формирование HTML-кода для вывода информации о детской площадке
    $info = "<p><strong>Покрытие:</strong> $coating</p>";
    $info .= "<p><strong>Возрастная группа:</strong> $age</p>";
    $info .= "<p><strong>Функции:</strong> $function</p>";
    $info .= "<p><strong>Меры безопасности:</strong> $safety</p>";
    $info .= "<p><strong>Инфраструктура:</strong> $infrastructure</p>";
    $info .= "<p><strong>Дата постройки:</strong> $construction_date</p>";
    $info .= "<p><strong>Срок эксплуатации:</strong> $expiry_date</p>";
    $info .= "<p><strong>Дата последнего обслуживания:</strong> $maintenance_date</p>";
    $info .= "<p><strong>Дополнительные удобства:</strong> $additional_facilities</p>";
    // Добавление тега img для отображения фотографии
    $info .= "<img src='" . htmlspecialchars($photo_url) . "' alt='Фотография площадки' style='max-width: 100%; height: auto;' />";
    
    // Вывод информации о детской площадке
    echo $info;
} else {
    // Если информации о площадке нет, выводим сообщение
    echo "Информация о площадке не найдена.";
}

// Закрытие соединения с базой данных
$conn->close();
?>