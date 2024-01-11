<?php

declare(strict_types=1);

namespace Gesparo\Homework\Infrastructure;

use Gesparo\Homework\AppException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

class ExceptionHandler
{
    public function handle(\Throwable $e): Response
    {
        return match (get_class($e)) {
            ResourceNotFoundException::class => $this->handeRouteNotFoundException($e),
            AppException::class => $this->handleAppException($e),
            default => $this->handleDefault($e),
        };
    }

    private function handeRouteNotFoundException(ResourceNotFoundException $e): Response
    {
        return new Response($e->getMessage(), Response::HTTP_NOT_FOUND);
    }

    private function handleAppException(AppException $e): Response
    {
        $code = $e->getCode();

        return match($code) {
            AppException::VALIDATION_ERROR => new JsonResponse($e->getData(), Response::HTTP_BAD_REQUEST),
            default => $this->handleDefault($e)
        };
    }

    private function handleDefault(\Throwable $e): Response
    {
        $exceptionClass = get_class($e);
        $responseMessage = <<<MESSAGE
            <h1>An error occurred</h1>
            <p>
                Exception class: $exceptionClass
                Message: {$e->getMessage()} 
                <br>
                <br>
                Trace:
                <pre>{$e->getTraceAsString()}</pre>
            </p>
            MESSAGE;

        return new Response($responseMessage, Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
