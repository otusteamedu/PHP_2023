<?php

declare(strict_types=1);

namespace Twent\Hw12;

use Symfony\Component\ErrorHandler\Exception\FlattenException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final class ErrorHandler
{
    public function __invoke(FlattenException $exception): Response
    {
        $msg = "Ошибка: {$exception->getMessage()}";

        return new JsonResponse(['error' => $msg], $exception->getStatusCode());
    }
}
