<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

$app = new \Lesson5\App();
return $app->run();

//if(isset($_REQUEST['string']) && $_REQUEST['string'] != ''){
//    $str = $_REQUEST['string'];
//
//    $errors = array();
//    $res = '';
//
//    $open = 0;
//    foreach(str_split($str) as $key => $symbol){
//        if($symbol == '('){
//            $open++;
//            $res .= $symbol;
//        }
//        if($symbol == ')') {
//            if($open == 0){
//                $errors[] = "Не ожидание закрытие скобок на символе $key";
//                $res .= "'$symbol'";
//            }
//            $open--;
//            $res .= $symbol;
//        }
//    }
//    if($open > 0){
//        $errors[] = "Скобки не закрыты $open";
//    }
//} else {
//    $errors[] = "string y может быть пустым";
//}
//
//if ($errors){
//    $res .= " \n".json_encode($errors, JSON_UNESCAPED_UNICODE);
//    HttpBadRequest($res);
//}
//
//function HttpBadRequest($message)
//{
//    http_response_code(400);
//    header('Content-Type: text/plain');
//    echo "Bad Request: \n$message";
//}