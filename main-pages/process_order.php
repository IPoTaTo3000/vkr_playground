<?php
session_start();

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

// Проверяем, был ли отправлен POST-запрос
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Получаем данные из POST-запроса
    $id_playground = $_POST['playground'];
    $description = $_POST['problem_description'];
    $id_user = $_SESSION['user']['id_user']; // Предполагается, что у пользователя есть идентификатор, который сохраняется в сессии при входе

    // Подготавливаем и выполняем запрос на вставку данных в таблицу Offer
    $date_p = date('Y-m-d H:i:s'); // текущая дата и время
    $sql = "INSERT INTO Offer (id_playground, Discription_p, id_user, date_p, status_p) VALUES ('$id_playground', '$description', '$id_user', '$date_p', 'active')";

    if ($conn->query($sql) === TRUE) {
        $offer_id = $conn->insert_id; // Получаем ID новой записи в таблице Offer

        // Обработка загруженных файлов
        if (isset($_FILES['photos']) && !empty($_FILES['photos']['name'][0])) {
            $upload_dir = '../uploads/'; // Директория для сохранения фотографий

            // Создаем директорию, если она не существует
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            // Проходимся по всем загруженным файлам
            foreach ($_FILES['photos']['name'] as $key => $photo_name) {
                $photo_tmp_name = $_FILES['photos']['tmp_name'][$key];
                $photo_path = $upload_dir . basename($photo_name);

                // Перемещаем загруженный файл в целевую директорию
                if (move_uploaded_file($photo_tmp_name, $photo_path)) {
                    // Сохраняем путь к файлу в базе данных
                    $sql_photo = "INSERT INTO OfferPhotos (id_offer, photo_path) VALUES ('$offer_id', '$photo_path')";
                    if (!$conn->query($sql_photo)) {
                        echo "Error: " . $sql_photo . "<br>" . $conn->error;
                    }
                } else {
                    echo "Failed to move uploaded file: " . $photo_tmp_name . " to " . $photo_path . "<br>";
                }
            }
        } else {
            echo "No files uploaded or files are empty.<br>";
        }

        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Закрываем соединение с базой данных
    $conn->close();

    // Перенаправляем пользователя на страницу accept.php
    header('Location: accept.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Две колонки с заголовком и подвалом</title>
    <link rel="stylesheet" href="../styles/process-style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</head>
<body>
    <header>
    <?php
    session_start();
    // Проверяем, есть ли пользователь вошедший в систему, и отображаем его имя
    if (isset($_SESSION['user']) && isset($_SESSION['user']['login'])) {
        echo "Пожалуйста сообщи о проблеме, " . htmlspecialchars($_SESSION['user']['login']) . "!";
        echo '<button class="btn me-3 btn-primary ms-3" onclick="location.href=\'../index.php\'">На главную</button>';
        echo '<button class="btn me-3 btn-danger ms-3" onclick="location.href=\'../index.php?logout=true\'">Выход</button>';
    } else {
        echo "Добро пожаловать!";
    }
    ?>
    </header>
    <div class="container">
        <div class="content">
            <div class="left-column">
            <h2>Выберите детскую площадку</h2>
    <form action="process_order.php" method="POST" enctype="multipart/form-data">
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

        // Запрос для получения списка городов
        $city_query = "SELECT DISTINCT city FROM Location";
        $city_result = $conn->query($city_query);
        ?>

        <div class="mb-3">
            <label for="city" class="form-label">Город</label>
            <select name="city" id="city" class="form-select">
                <option value=''>Выберите город</option>
                <?php
                while ($row = $city_result->fetch_assoc()) {
                    echo "<option value='" . $row['city'] . "'>" . $row['city'] . "</option>";
                }
                ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="district" class="form-label">Район</label>
            <select name="district" id="district" class="form-select">
                <option value=''>Выберите район</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="residential_complex" class="form-label">Жилой комплекс</label>
            <select name="residential_complex" id="residential_complex" class="form-select">
                <option value=''>Выберите жилой комплекс</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="playground" class="form-label">Детская площадка</label>
            <select name="playground" id="playground" class="form-select">
                <option value=''>Выберите детскую площадку</option>
            </select>
        </div>

        <div id="error_message" class="error-message"></div>
        <div id="error_message3" class="error-message"></div>
        <h3>Пожалуйста, опишите проблему ниже</h3>
        
        <div class="mb-3">
            <textarea name="problem_description" id="problem_description" rows="5" class="form-control"></textarea>
        </div>
        
        <!-- Новая форма загрузки фотографий -->
        <div class="mb-3">
            <label for="photos" class="form-label">Загрузите фотографии</label>
            <input type="file" name="photos[]" id="photos" multiple class="form-control">
        </div>

        <input type="submit" value="Отправить" id="submit_problem" class="btn btn-primary">
    </form>

    <div id="error_message2" class="error-message"></div>
            </div>
            <div class="right-column">
                <div id="playground_info"></div>
            </div>
        </div>
    </div>
    <footer>
        &copy; 2024 Все права защищены. Powered by: @alex.anfimov
    </footer>
    <script>
        // Функция для получения районов на основе выбранного города
        $('#city').change(function(){
            var city = $(this).val();
            $.ajax({
                url: '../ajax/get_districts.php', // Файл для обработки запроса
                method: 'POST',
                data: {city: city},
                success: function(data){
                    $('#district').html(data);
                }
            });
        });

        // Функция для получения жилых комплексов на основе выбранного района
        $('#district').change(function(){
            var district = $(this).val();
            $.ajax({
                url: '../ajax/get_complex.php', // Файл для обработки запроса
                method: 'POST',
                data: {district: district},
                success: function(data){
                    $('#residential_complex').html(data);
                }
            });
        });

         // Функция для получения детских площадок на основе выбранного жилого комплекса
    $('#residential_complex').change(function(){
        var complex = $(this).val();
        $.ajax({
            url: '../ajax/get_playgrounds.php', // Файл для обработки запроса
            method: 'POST',
            data: {complex: complex},
            success: function(data){
                $('#playground').html(data);
            }
        });
    });

    // Функция для обновления информации о детской площадке при выборе из списка
$('#playground').change(function(){
    var playground_id = $(this).val();
    $.ajax({
        url: '../ajax/get_playground_info.php', // Файл для обработки запроса
        method: 'POST',
        data: {playground_id: playground_id},
        success: function(data){
            $('#playground_info').html(data);
        }
    });
});

    $('#submit_problem').click(function() {
    var city = $('#city').val();
    var district = $('#district').val();
    var complex = $('#residential_complex').val();
    var playground = $('#playground').val();
    var problemDescription = $('#problem_description').val().trim();

    var isValid = true; // Флаг валидности формы

    // Проверка наличия выбора всех необходимых полей
    if (city === '' || district === '' || complex === '' || playground === '') {
        $('#error_message3').text('Вы не выбрали детскую площадку.');
        isValid = false; // Устанавливаем флаг в false
    } else {
        $('#error_message3').text(''); // Очистка сообщения об ошибке
    }

    // Проверка заполнения поля описания проблемы
    if (problemDescription === '') {
        $('#error_message2').text('Вы не описали проблему.');
        isValid = false; // Устанавливаем флаг в false
    } else {
        $('#error_message2').text(''); // Очистка сообщения об ошибке
    }

    // Если форма не валидна, отменяем отправку
    if (!isValid) {
        return false;
    }

    // Если все проверки пройдены, перенаправляем на accept.php
    window.location.href = 'accept.php';
});
    </script>
</body>
</html>