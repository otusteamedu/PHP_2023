<?php


require '../../vendor/autoload.php';

include("../Src/App.php");
use App\Src\App;


$app = new App();
$app->run();


// $validator =  new Validator();
// $message = "Cтрока корректна";
// try {
//     header('HTTP/1.1 ' . 200);
//     $validator->validate($_POST['string'] ?? '');
// } catch (Exception $e) {
//     header('HTTP/1.1 ' . 400);
//     $message = $e->getMessage();
// }

// try {
//     $redis = new Redis();
//     $redis->connect('redis', 6379);
//     echo "Редис работает<br/>";
// } catch (Exception $e) {
//     echo $e->getMessage() . "<br/>";
// }


// echo 'Session id: ' . session_id() . '<br>';
// echo "Запрос обработал контейнер: " . $_SERVER['HOSTNAME'] . '<br>';
// echo "Запрос обработал сервер nginx c IP: " . $_SERVER['SERVER_ADDR'] . '<br>';
// echo "<br><br>string: " . ($_POST['string'] ?? '') . '<br>';
// echo "Обработка строки string: " . $message;