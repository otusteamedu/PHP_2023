<?php

namespace App\Infrastructure\EventListener;

use App\Domain\Exception\InvalidArgumentException;
use App\Domain\Exception\NotFoundException;
use App\Domain\Exception\SecurityException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if ($exception instanceof HttpExceptionInterface) {
            $response = new JsonResponse(['message' => $exception->getMessage()], $exception->getStatusCode());
            $response->headers->replace($exception->getHeaders());
        } elseif ($exception instanceof InvalidArgumentException) {
            $response = new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_BAD_REQUEST);
        } elseif ($exception instanceof NotFoundException) {
            $response = new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_NOT_FOUND);
        } elseif ($exception instanceof SecurityException) {
            $response = new JsonResponse(['message' => $exception->getMessage()], Response::HTTP_FORBIDDEN);
        } else {
            $response = new JsonResponse(['message' => 'Server error'], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $event->setResponse($response);
    }
}
