<?php

require_once __DIR__ . '/../vendor/autoload.php';
use Pecee\Http\Middleware\Exceptions\TokenMismatchException;
use Pecee\SimpleRouter\Exceptions\HttpException;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Sva\Common\App\App;

$app = App::getInstance();
try {
    $app->start($argv);
} catch (TokenMismatchException | NotFoundHttpException | HttpException $e) {
}
