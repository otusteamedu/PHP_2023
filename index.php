<?php
declare(strict_types=1);
use Ekovalev\Otus\Helpers\Validator;

require_once __DIR__ . '/vendor/autoload.php';

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

echo "Привет, Otus!<br>".date("d.m.Y H:i:s")."<br><br>";
echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'];