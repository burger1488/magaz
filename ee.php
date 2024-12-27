?php

// Подключение к базе данных

$host = '127.0.0.1:3300';

$user = 'shop'; 

// имя пользователя базы данных

$password = '';

// Пароль к базе данных

$dbname = 'shop';

// Создание подключения

$conn = new mysqli(Shost, $user, $password, $dbname);

// Проверка соединения

if ($conn->connect_error) {

die("Ошибка подключения:" $conn->connect_error);

}

// обработка данных формы

if ($_SERVER["REQUEST_METHOD"] == "POST") {

$username = $conn->real_escape_string($_POST['username']);

$email = $conn->real_escape_string($_POST['email']);

$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

// Проверка существующего пользователя

$checkuser = "SELECT FROM users WHERE email="$email"";

$result = $conn->query($checkuser);

if ($result->num_rows > 0) {

echo "Email уже зарегистрирован!";

} else {

// вставка данных в базу

$sql = "INSERT INTO users (username, email, password)

VALUES ('$username', '$email', 'Spassword")";

if ($conn->query($sql) === TRUE) {

echo "Регистрация прошла успешно!";

} else {

echo "Ошибка:" $sql. "<br>", $conn->error;

}
}
}