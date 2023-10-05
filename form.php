<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Подключение стилей Bootstrap для оформления страницы -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Результат обращения</title>
</head>
<body>
    <div class="container mt-5">
        <h1>Результат обращения</h1>
        <?php
        //Импортируем PHPMailer (https://packagist.org/packages/phpmailer/phpmailer#dev-master)
        use PHPMailer\PHPMailer\PHPMailer;
        use PHPMailer\PHPMailer\SMTP;
        use PHPMailer\PHPMailer\Exception;
        
        require 'vendor\phpmailer\phpmailer\src\Exception.php';
        require 'vendor\phpmailer\phpmailer\src\PHPMailer.php';
        require 'vendor\phpmailer\phpmailer\src\SMTP.php';

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
        // Проверка, была ли отправлена форма методом POST
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = trim($_POST["name"]);
            $email = trim($_POST["email"]);
            $message = trim($_POST["message"]);
            $gender = $_POST["gender"];
            $category = $_POST["category"];
            $subscribe = isset($_POST["subscribe"]) ? $_POST["subscribe"] : "Нет"; 
            $targetDir = "uploads/";
            $path_parts = pathinfo($_FILES["file"]["name"]);
            $uploadedFileName = $path_parts['filename'] . '_' . time() . '.' . $path_parts['extension'];
            $targetFilePath = $targetDir . $uploadedFileName;
            // Перемещение загруженного файла в указанную папку
            if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                $successMessage = "Файл успешно загружен и сохранен в папке 'uploads'.";
            } else {
                echo "Ошибка при загрузке файла.";
            }

            require 'vendor/autoload.php';
            // Создаем новый объект PHPMailer
            $mail = new PHPMailer(true);

            try {
                // Устанавливаем параметры сервера SMTP 
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com'; // Адрес SMTP-сервера (от Google)
                $mail->SMTPAuth = true; //Без этого код не работает(Это двухэтапная аутинтификация Google)
                $mail->Username = 'testprojectcontactus@gmail.com'; // Имя пользователя SMTP (Пароль и данные в файле README)
                $mail->Password = 'macm asym iojw bdgl'; // Пароль SMTP (Пароль и данные в файле README)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Шифрование
                $mail->Port = 465; // Используйте 465 для SSL
                $mail->CharSet = 'UTF-8'; // Указываем UTF-8, что бы "Тема" в почте отображалась буквами)
                $mail->Subject = 'Новое сообщение от ' . $name;

                

                // Устанавливаем параметры отправителя и получателя
                $mail->setFrom($email, $name);
                $mail->addAddress('testprojectcontactus@gmail.com'); // Адрес получателя (Администратор)
                $mail->addReplyTo($email, $name);

                // Устанавливаем параметры письма(Как будет отображаться отправленное письмо)
                $mail->isHTML(true);
                $mail->Subject = 'Новое сообщение от ' . $name;
                $mail->Body = "Имя: $name<br>Email: $email<br>Сообщение: $message<br>Пол: $gender<br>Категория: $category<br>Подписка на рассылку: $subscribe";

                // Добавляем вложение, если оно есть
                if (!empty($uploadedFileName)) {
                    $mail->addAttachment($targetFilePath);
                }

                // Отправляем письмо
                $mail->send();

                // Выводим сообщение об успешной отправке
                echo '<div class="alert alert-success" role="alert">';
                echo 'Ваши данные успешно отправлены!';
                echo '</div>';
            } catch (Exception $e) {
                // Выводим сообщение об ошибке, если отправка не удалась
                echo '<div class="alert alert-danger" role="alert">';
                echo 'Произошла ошибка при отправке данных. Пожалуйста, попробуйте еще раз.';
                echo '</div>';
            }

            // Проверяем, что обязательные поля (имя, email, сообщение) не пусты
            if (!empty($name) && !empty($email) && !empty($message)) {
                $sql = "INSERT INTO contactus (имя, email, сообщение, пол, категория, подписка, файл)
                        VALUES ('$name', '$email', '$message', '$gender', '$category', '$subscribe', '$uploadedFileName')";

                if ($conn->query($sql) === TRUE) {
                    $successMessage = "Данные успешно добавлены в базу данных.";
                } else {
                    echo "Ошибка при добавлении данных: " . $conn->error;
                }
            } else {
                echo "Пожалуйста, заполните обязательные поля (имя, email, сообщение).";
            }

            $conn->close();// Закрытие соединения с базой данных
        }
        ?>
        <!-- Кнопки для перехода на другие страницы -->
        <button class="btn btn-primary mt-3" onclick="location.href='index.html'">Вернуться на главную</button>
        <button class="btn btn-info mt-3" onclick="location.href='result.php'">Перейти к результатам</button>
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