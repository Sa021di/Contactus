<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Подключение стилей Bootstrap для оформления страницы -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Результаты обращений</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Результаты обращений</h1>
        <?php
        // Подключение к базе данных MySQL
        $servername = "ContactUs";
        $username = "root";
        $password = "root";
        $dbname = "contactus";
        $conn = new mysqli($servername, $username, $password, $dbname);
        // Проверка соединения с базой данных
        if ($conn->connect_error) {
            die("Ошибка подключения к базе данных: " . $conn->connect_error);
        }
        // Количество записей на одной странице
        $recordsPerPage = 20;
        // Определение текущей страницы
        if (isset($_GET['page']) && is_numeric($_GET['page'])) {
            $currentPage = $_GET['page'];
        } else {
            $currentPage = 1;
        }
        // Вычисление смещения для выборки записей из базы данных
        $offset = ($currentPage - 1) * $recordsPerPage;
        // SQL-запрос для выборки данных из таблицы contactus с учетом пагинации
        $sql = "SELECT * FROM contactus LIMIT $offset, $recordsPerPage";
        // Выполнение SQL-запроса
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            // Вывод таблицы с данными
            echo "<table class='table table-bordered'>";
            echo "<thead><tr><th>Номер</th><th>ID</th><th>Имя</th><th>Email</th><th>Сообщение</th><th>Пол</th><th>Категория</th><th>Подписка</th><th>Файл</th><th>Дата отправки</th></tr></thead><tbody>";
            $counter = 1 + ($currentPage - 1) * $recordsPerPage;
            while ($row = $result->fetch_assoc()) {
                // Вывод каждой строки с данными
                echo "<tr>";
                echo "<td>" . $counter . "</td>";
                echo "<td>" . $row["id"] . "</td>";
                echo "<td>" . $row["имя"] . "</td>";
                echo "<td>" . $row["email"] . "</td>";
                echo "<td>" . $row["сообщение"] . "</td>";
                echo "<td>" . $row["пол"] . "</td>";
                echo "<td>" . $row["категория"] . "</td>";
                echo "<td>" . $row["подписка"] . "</td>";
                echo "<td><a href='uploads/" . $row["файл"] . "' target='_blank'>Скачать</a></td>";
                echo "<td>" . $row["Время отправки"] . "</td>"; 
                echo "</tr>";
                $counter++;
            }
            echo "</tbody></table>";
        } else {
            echo "Нет данных для отображения.";
        }
        // SQL-запрос для определения общего количества записей
        $sqlTotalRecords = "SELECT COUNT(*) as total FROM contactus";
        // Выполнение запроса
        $resultTotalRecords = $conn->query($sqlTotalRecords);

        if ($resultTotalRecords) {
            $rowTotalRecords = $resultTotalRecords->fetch_assoc();
            $totalRecords = $rowTotalRecords['total'];
        } else {
            $totalRecords = 0;
        }
        // Вычисление общего количества страниц
        $totalPages = ceil($totalRecords / $recordsPerPage);
        // Вывод пагинации
        echo "<div class='pagination'>";
        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                echo "<span class='current-page'>$i</span>";
            } else {
                echo "<a href='?page=$i'>$i</a>";
            }
        }
        echo "</div>";
        // Закрытие соединения с базой данных
        $conn->close();
        ?>
        <!-- Кнопка для перехода на другие страницы -->
        <button class="btn btn-primary mt-3" onclick="location.href='index.html'">Отправить новое сообщение</button>
    </div>
    <!-- Подключение скриптов 
      jQuery для облегчения манипуляции с элементами страницы и заимодействие с DOM (Document Object Model) 
      Popper.js для управления всплывающими подсказками и позиционированием элементов на странице. (Совместно с Bootstrap4)
      Bootsrap для того что-бы придать готовые стили к нашему серому сайту. -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
