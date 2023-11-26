<?php

session_start();

//Проверка сессий
echo 'Hostname: ' . $_SERVER['HOSTNAME'] . "<br/>";

if (isset($_SESSION['test'])) {
    echo 'Session works fine!';
} else {
    $_SESSION['test'] = 'test_key';
}

//Проверка MySQL
try {
    $pdo = new PDO('mysql:host=mysql;dbname=test', 'test', 'test');
    $response = $pdo->query('SELECT 1');
    $response->execute();
    print_r($response->fetch());
} catch (Throwable $throwable) {
    print_r($throwable);
    echo 'Соединение с БД НЕ установлено!';
}

try {
    $string = $_POST['string'] ?? null;
    if (empty($string)) {
        throw new Exception('Строка неккоректна: не допускается пустая строка');
    }

    $string = str_split($string);

    $i = 0;
    $j = $i;
    $k = $j;
    $length = count($string) - 1;

    $count = 0;

    while ($i <= $length) {
        if ($string[$i] === '(') {
            $count++;
            $j = $k;
            while ($j < $length) {
                $j++;
                if ($string[$j] === ')') {
                    $k = $j;
                    $i++;
                    continue 2;
                }
            }
            throw new Exception('Строка неккоректна: не закрыта скобка в позиции ' . $i);
        } else if ($string[$i] === ')') {
            $count--;
            $i++;
        } else {
            throw new Exception('Строка неккоректна: неизвестный символ в позиции ' . $i);
        }
    }

    if ($count !== 0) { //проверка на лишние скобки
        throw new Exception('Строка неккоректна: есть лишние скобки');
    }

    echo 'Строка корректна';
    http_response_code(200);
} catch (Throwable $t) {
    echo $t->getMessage();
    http_response_code(400);
}