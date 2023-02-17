<?php
require __DIR__.'/../vendor/autoload.php';

if(strtolower($_SERVER['REQUEST_METHOD']) == 'post') {
    $incomingStr = $_POST['string'];
    $pattern = '(()()()()))((((()()()))(()()()(((()))))))';
    $openCnt = substr_count($pattern, '(');
    $closeCnt = substr_count($pattern, ')');

    try {
        if (empty($incomingStr)) {
            throw new Exception('Строка пустая');
        }

        if($openCnt != substr_count($incomingStr, '(')) {
            throw new Exception('Количество открытых скобок не верное');
        }

        if($closeCnt != substr_count($incomingStr, ')')) {
            throw new Exception('Количество закрытых скобок не верное');
        }

        echo "Everything ok";
    } catch (Exception $e) {
        http_response_code(400);
        echo $e->getMessage();
    }


}

