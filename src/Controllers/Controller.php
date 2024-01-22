<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Database\DatabaseInterface;
use App\Http\RequestInterface;
use JetBrains\PhpStorm\NoReturn;

abstract class Controller
{
    private RequestInterface $request;
    private DatabaseInterface $database;

    public function __construct(DatabaseInterface $database)
    {
        $this->database = $database;
    }

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    public function db(): DatabaseInterface
    {
        return $this->database;
    }

    #[NoReturn] public function wrongBody(): void
    {
        http_response_code(400);
        echo 'Неверное тело запроса';
        exit();
    }
}
