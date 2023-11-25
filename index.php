<?php
declare(strict_types=1);
use Ekovalev\Otus\Helpers\Validator;

require_once __DIR__ . '/vendor/autoload.php';

session_start();
if (empty($_SESSION['check'])) {
    $_SESSION['check'] = rand(1000, 5000);
}

if (isset($_POST['string'])){
    try {
        $resValid = Validator::openingClosingChar($_POST['string'], '(', ')');
        if(is_string($resValid)){
            throw new \Exception($resValid);
        }else{
            echo 'Всё хорошо';
        }

    } catch (InvalidArgumentException $error) {
        http_response_code(400);
        echo $error->getMessage();
    }
    exit;
}

$showRes = [
    'Привет, Otus',
    date("d.m.Y H:i:s"),
    $_SERVER['SERVER_ADDR'],
    $_SERVER['HOSTNAME'],
    $_SESSION['check'],
];

echo '<pre>';
print_r($showRes);