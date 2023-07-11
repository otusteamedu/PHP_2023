<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Infrastructure\Exception;

use Imitronov\Hw12\Domain\Exception\InvalidArgumentException;
use Imitronov\Hw12\Infrastructure\Http\JsonResponse;
use Imitronov\Hw12\Infrastructure\Http\Response;

final class ExceptionHandler
{
    public function handle(\Throwable $exception): Response
    {
        if ($exception instanceof InvalidArgumentException) {
            return new JsonResponse(
                $exception->getUserMessages(),
                400,
            );
        }

        return new JsonResponse(
            ['error' => $exception->getMessage()],
            500,
        );
    }
}
