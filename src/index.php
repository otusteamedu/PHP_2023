<?php

require_once 'vendor/autoload.php';
require_once 'config.php';

// Connecting to the database
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

// Checking the database connection for errors
if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

// Creating a new user gateway
$userGateway = new App\Model\UserGateway($mysqli);

// Getting all users from the database
$users = $userGateway->findAll();
// if get POST request, update user
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $result = $userGateway->update($user_id, $name, $email);
    if ($result) {
        echo "Данные пользователя успешно обновлены!";
    } else {
        echo "Ошибка при обновлении данных пользователя.";
    }
    exit;
}
// Closing the database connection
header('Content-Type: application/json');
echo json_encode($users);
