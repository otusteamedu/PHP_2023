<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Http\RequestInterface;
use App\Storage\StorageInterface;
use App\Validator\ValidatorInterface;
use Exception;
use JetBrains\PhpStorm\NoReturn;

abstract class Controller
{
    private RequestInterface $request;
    private StorageInterface $storage;
    private ValidatorInterface $validator;

    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    public function setRequest(RequestInterface $request): void
    {
        $this->request = $request;
    }

    public function storage(): StorageInterface
    {
        return $this->storage;
    }

    public function setStorage(StorageInterface $storage): void
    {
        $this->storage = $storage;
    }

    public function getValidator(): ValidatorInterface
    {
        return $this->validator;
    }

    public function setValidator(ValidatorInterface $validator): void
    {
        $this->validator = $validator;
    }

    #[NoReturn] public function wrongBody(): void
    {
        http_response_code(400);
        echo 'Неверное тело запроса';
        exit();
    }

    public function errorRequest(Exception $exception): void
    {
        http_response_code(400);
        echo 'Ошибка запроса' . PHP_EOL;
        echo $exception->getMessage();
    }
}
