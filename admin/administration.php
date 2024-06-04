<?php
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['login'] !== 'admin') {
    header('Location: ../profile/login.php');
    exit();
}
// Подключение к базе данных
require_once("../db+php/connect.php");

// Функция для получения данных из базы данных с использованием подготовленных запросов
function fetchData($connect, $query) {
    $stmt = $connect->prepare($query);
    $stmt->execute();
    return $stmt->get_result();
}

// Запрос для получения данных о заявках только со статусами "active" и "in progress"
$offer_query = "SELECT * FROM offer WHERE status_p IN ('active', 'in progress')";
$offer_result = fetchData($connect, $offer_query);

// Запрос для получения списка возможных работ
$work_query = "SELECT * FROM work";
$work_result = fetchData($connect, $work_query);

// Запрос для получения данных об исполнителях
$worker_query = "SELECT * FROM worker";
$worker_result = fetchData($connect, $worker_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Администрирование</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
</head>
<style>
    header {
        background-color: #f2f2f2;
        color: #333;
        text-align: right;
        padding: 10px 0;
    }
    footer {
        background-color: #f2f2f2;
        color: #333;
        text-align: center;
        padding: 10px 0;
        position: fixed;
        bottom: 0;
        width: 100%;
    }
</style>
<body>
    <header>
    <?php
    // Проверяем, есть ли пользователь вошедший в систему, и отображаем его имя
    if (isset($_SESSION['user']) && isset($_SESSION['user']['login'])) {
        echo "ADMIN ";
        echo '<button class="btn mb-2 me-3 btn-primary ms-2" onclick="location.href=\'mainadmin.php\'">Назад</button>';
        echo '<button class="btn mb-2 me-3 btn-danger ms-2" onclick="location.href=\'../index.php?logout=true\'">Выход</button>';
    } else {
        echo "Добро пожаловать!";
    }
    ?>
    </header>
    <div class="container mt-5">
    <h1 class="mb-4">Управление заявками</h1>

    <form action="../scrypts/process.php" method="post">
        <h2>Список заявок</h2>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Дата</th>
                        <th>Статус</th>
                        <th>Описание</th>
                        <th>ID пользователя</th>
                        <th>ID площадки</th>
                        <th>Выбор работы</th>
                        <th>Выбор исполнителя</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
// Запрос для получения данных о заявках и их фотографиях без дублирования заявок
$offer_query = "SELECT o.*, GROUP_CONCAT(op.photo_path) AS photo_paths
                FROM offer o
                LEFT JOIN OfferPhotos op ON o.id_offer = op.id_offer
                WHERE o.status_p IN ('active', 'in progress')
                GROUP BY o.id_offer";
$offer_result = fetchData($connect, $offer_query);

// Вывод данных о заявках и кнопок для просмотра фотографий
while ($row = mysqli_fetch_assoc($offer_result)) {
    echo "<tr>";
    echo "<td>{$row['id_offer']}</td>";
    echo "<td>{$row['date_p']}</td>";
    echo "<td>{$row['status_p']}</td>";
    echo "<td>{$row['discription_p']}</td>";
    echo "<td>{$row['id_user']}</td>";
    echo "<td>{$row['id_playground']}</td>";

    if ($row['status_p'] !== 'in progress') {
        echo "<td><select class='form-select' name='work[{$row['id_offer']}]'>";
        // Добавляем пустое значение по умолчанию
        echo "<option value=''>Выберите работу</option>";
        while ($work_row = mysqli_fetch_assoc($work_result)) {
            echo "<option value='{$work_row['id_work']}'>{$work_row['Name']}</option>";
        }
        echo "</select></td>";
        mysqli_data_seek($work_result, 0);

        echo "<td><select class='form-select' name='worker[{$row['id_offer']}]'>";
        // Добавляем пустое значение по умолчанию
        echo "<option value=''>Выберите исполнителя</option>";
        while ($worker_row = mysqli_fetch_assoc($worker_result)) {
            echo "<option value='{$worker_row['id_worker']}'>{$worker_row['Company_name']}</option>";
        }
        echo "</select></td>";
        mysqli_data_seek($worker_result, 0);
    } else {
        echo "<td></td><td></td>";
    }

    // Добавление кнопки просмотра фотографий через модальное окно
if (!empty($row['photo_paths'])) {
    $photo_paths = explode(',', $row['photo_paths']);
    echo "<td>";
    echo "<button class='btn btn-primary' onclick='openPhotoModal(".json_encode($photo_paths).")'>Просмотреть фото</button>";
    echo "</td>";
} else {
    echo "<td>Нет фотографии</td>";
}

    echo "</tr>";
}   
                    ?>
                </tbody>
            </table>
        </div>
        <button class="btn btn-primary" type="submit">Сохранить</button>
    </div>
    <!-- Добавляем модальное окно -->
<div class="modal" id="photoModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Просмотр фотографий</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <div id="photoCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">
            <!-- Здесь будут отображаться фотографии -->
          </div>
          <button class="carousel-control-prev" type="button" data-bs-target="#photoCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#photoCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>
    <footer>
        &copy; 2024 Все права защищены. Powered by: @alex.anfimov
    </footer>
<script>
    // JavaScript для активации модальных окон Bootstrap
    var myModal = new bootstrap.Modal(document.getElementById('photoModal'));
    
    // JavaScript для отображения фотографий в модальном окне
    function openPhotoModal(photoPaths) {
        event.preventDefault();
        var carouselInner = document.querySelector('#photoCarousel .carousel-inner');
        carouselInner.innerHTML = ''; // Очищаем содержимое карусели перед добавлением новых фотографий
        photoPaths.forEach(function(photoPath, index) {
            var carouselItem = document.createElement('div');
            carouselItem.classList.add('carousel-item');
            if (index === 0) {
                carouselItem.classList.add('active');
            }
            var img = document.createElement('img');
            img.src = photoPath;
            img.classList.add('d-block', 'w-100');
            carouselItem.appendChild(img);
            carouselInner.appendChild(carouselItem);
        });

        // Убедимся, что модальное окно уже открыто
        myModal.show();
    }
</script>
</body>
</html>