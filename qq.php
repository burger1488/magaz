<?php
// Начинаем сессию
session_start();

// Подключение к базе данных
$servername = "127.0.0.1:3300"; // Проверьте, правильный ли порт
$username = "root"; // Имя пользователя базы данных
$password = ""; // Пароль базы данных
$dbname = "shop"; // Название базы данных

// Создание подключения
$conn = new mysqli($servername, $username, $password, $dbname);

// Проверка подключения
if ($conn->connect_error) {
    die("Ошибка подключения: " . $conn->connect_error);
}

// Обработка данных формы входа
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = mysqli_real_escape_string($conn, $_POST['username']);
    $user_password = mysqli_real_escape_string($conn, $_POST['password']);

    // Проверка, что поля не пустые
    if (empty($user_name) || empty($user_password)) {
        echo "Все поля обязательны для заполнения!";
    } else {
        // SQL запрос для поиска пользователя в базе данных
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $user_name);
        $stmt->execute();
        $result = $stmt->get_result();

        // Если пользователь найден
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            // Проверка пароля
            if (password_verify($user_password, $row['password'])) {
                // Успешный вход
                $_SESSION['user_id'] = $row['id']; // Сохраняем ID пользователя в сессии
                $_SESSION['username'] = $row['username']; // Сохраняем имя пользователя в сессии

                // Перенаправление на защищенную страницу
                header('Location: dashboard.php');
                exit; // Прерываем выполнение скрипта после редиректа
            } else {
                echo "Неверный пароль!";
            }
        } else {
            echo "Пользователь не найден!";
        }
    }
}

// Закрытие подключения
$conn->close();
?>
