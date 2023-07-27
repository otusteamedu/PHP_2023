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

// Closing the database connection
header('Content-Type: application/json');
echo json_encode($users);
