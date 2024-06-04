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

// Получение значения жилого комплекса из AJAX запроса
$complex = $_POST['complex'];

// Запрос для получения детских площадок выбранного жилого комплекса
$playground_query = "SELECT id_playground, id_location 
                    FROM Playground 
                    WHERE id_location IN (SELECT id_location FROM Location WHERE Residential_complex = '$complex')";
$playground_result = $conn->query($playground_query);

// Проверка наличия данных
if ($playground_result->num_rows > 0) {
    // Формирование HTML-кода для выпадающего списка детских площадок
    $options = "<option value=''>Выберите детскую площадку</option>";
    while ($row = $playground_result->fetch_assoc()) {
        $options .= "<option value='" . $row['id_playground'] . "'>" . $row['id_playground'] . "</option>";
    }
} else {
    // Если площадок нет, выводим сообщение
    $options = "<option value=''>Нет доступных детских площадок</option>";
}

// Вывод HTML-кода для обновления выпадающего списка детских площадок в форме
echo $options;

// Закрытие соединения с базой данных
$conn->close();
?>