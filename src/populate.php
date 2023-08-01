<?php

require_once 'vendor/autoload.php';
require_once 'config.php';

$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASS);

if ($mysqli->connect_errno) {
    die("Connection failed: " . $mysqli->connect_error);
}

$mysqli->query("DROP DATABASE IF EXISTS " . DB_NAME);

$mysqli->query("CREATE DATABASE " . DB_NAME);

$mysqli->select_db(DB_NAME);

$mysqli->query("CREATE TABLE users (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL
)");

for ($i = 1; $i <= 10; $i++) {
    $name = "User " . $i;
    $email = "user" . $i . "@example.com";

    $name = $mysqli->real_escape_string($name);
    $email = $mysqli->real_escape_string($email);

    $mysqli->query("INSERT INTO users (name, email) VALUES ('$name', '$email')");
}

$mysqli->close();

echo "Database populated successfully!";
