<?php

require 'vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;

$app = new \Slim\App();

/** 
 * Выводит Log запросов из Memcached 
 */

$app->get('/', function (Request $req,  Response $res, $args = []) {
    $logs = new Root\Www\Logs();

    $list = $logs->getList();
    echo '<h1>Logs</h1>';
    if($list) {
       foreach($list as $log) {
        echo $log.'<br />';
       }
    } else {
        echo '<h3>Записей нет</h3>';
    }
});

/** 
 * Принимает параметр String обрабатывает и записывает в Memcached 
 */

$app->post('/', function (Request $req,  Response $res, $args = []) {
    $body = $req->getParsedBody();

    $parser = new Root\Www\StringParser($body['string']);
    $parser->run();

    $logs = new Root\Www\Logs();
    $logs->addRow('Message:&nbsp;'.$parser->getMessage());

    if(!$parser->validate())
        return $res->withStatus(400)->write($parser->getMessage());

    return $res->write($parser->getMessage());
});

$app->run();
