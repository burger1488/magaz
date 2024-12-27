<?php
// Подключаемся к базе данных
$servername = "127.0.0.1:3300";
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль базы данных
$dbname = "shop"; // Имя вашей базы данных без пробела в конце

// Создаем подключение
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверяем подключение
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Получаем данные из формы
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = mysqli_real_escape_string($conn, $_POST['username']);
    $user_email = mysqli_real_escape_string($conn, $_POST['email']);
    $user_password = mysqli_real_escape_string($conn, $_POST['password']);

    // Хешируем пароль перед сохранением в базе данных
    $hashed_password = password_hash($user_password, PASSWORD_DEFAULT);

    // Подготовка SQL-запроса для вставки данных в таблицу
    $sql = "INSERT INTO users (username, email, password) VALUES ('$user_name', '$user_email', '$hashed_password')";

    // Выполняем запрос
    if ($conn->query($sql) === TRUE) {
        echo "Новый пользователь зарегистрирован успешно!";
        // Редирект на страницу входа или на главную страницу
        header('Location: qq.html');
    } else {
        echo "Ошибка: " . $sql . "<br>" . $conn->error;
    }

    // Закрываем соединение
    $conn->close();
}
?>