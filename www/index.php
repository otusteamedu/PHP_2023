<?php

require 'vendor/autoload.php';

use Nalofree\Hw5\Router;

$router = new Router();

$router->addRoute('POST', '/check', 'Nalofree\Hw5\indexController', 'check');
$router->addRoute('GET', '/', 'Nalofree\Hw5\indexController', 'index');

$router->handleRequest();

//$router->addRoute('GET', '/form', function () {
//    echo "Welcome to the home page!";
//});
//
//$router->addRoute('POST', '/', function () {
//    echo "Login request handled.";
//});
//
//try {
//    $router->handleRequest();
//} catch (Exception $e) {
//    print_r($e);
//}

//if ($_SERVER['REQUEST_URI'] === '/form') {
//    require "./views/form.php";
//} else {
//    if ($_SERVER['REQUEST_URI'] !== '/') { // любой неверный роут ведет к ошибке
//        header('HTTP/1.1 400 Bad Reuqest');
//        exit('Текст, что всё плохо');
//    }
//    if (isset($_POST['string'])) {
//        $checker = new EmailChecker($_POST['string']);
//        if (empty($checker->check())) {
//            header('HTTP/1.1 400 Bad Reuqest');
//            exit('Ни одного емейла. Текст, что всё плохо');
//        } else {
//            header('HTTP/1.1 200 OK');
//            echo "<pre>";
//            print_r($checker->check());
//            echo "</pre>";
//            exit('Текст, что всё хорошо');
//        }
//    } else {
//        header('HTTP/1.1 400 Bad Reuqest');
//        exit('В запросе нет нужных данных. Текст, что всё плохо');
//    }
//}
