<?php

declare(strict_types=1);

namespace App\Infrastructure\EventListener;

use App\Domain\Exception\ForbiddenException;
use App\Domain\Exception\NotFoundException;
use App\Domain\Exception\TooManyRequestsException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

final class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpExceptionInterface) {
            $response = new JsonResponse(['message' => $exception->getMessage()], $exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } elseif ($exception instanceof ForbiddenException) {
            $response = new JsonResponse(
                ['message' => $exception->getMessage()],
                Response::HTTP_FORBIDDEN,
            );
        } elseif ($exception instanceof NotFoundException) {
            $response = new JsonResponse(
                ['message' => $exception->getMessage()],
                Response::HTTP_NOT_FOUND,
            );
        } elseif ($exception instanceof TooManyRequestsException) {
            $response = new JsonResponse(
                ['message' => $exception->getMessage()],
                Response::HTTP_TOO_MANY_REQUESTS,
            );
        } else {
            $response = new JsonResponse(['message' => 'Server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}
