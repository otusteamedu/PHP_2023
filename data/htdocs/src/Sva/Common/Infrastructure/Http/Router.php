<?php

namespace Sva\Common\Infrastructure\Http;

use Pecee\Http\Middleware\Exceptions\TokenMismatchException;
use Pecee\SimpleRouter\Exceptions\HttpException;
use Pecee\SimpleRouter\Exceptions\NotFoundHttpException;
use Pecee\SimpleRouter\SimpleRouter;

class Router
{
    /**
     * @throws HttpException
     * @throws NotFoundHttpException
     * @throws TokenMismatchException
     */
    public function start(): void
    {
        require_once __DIR__ . '/../../../../../routes.php';
//        SimpleRouter::setDefaultNamespace('\Sva\Infrastructure\Http\Controllers');
        SimpleRouter::start();
    }

    public function get(string $url, $action, ?string $name = null): void
    {
        SimpleRouter::get($url, $action, $name);
    }

    public function post(string $url, $action, ?string $name = null): void
    {
        SimpleRouter::post($url, $action, $name);
    }
}
