<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ValidationException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ValidationExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if($exception instanceof ValidationException) {
            $data = [
                'title' => $exception->getMessage(),
                'errors' => $exception->getErrors(),
            ];

            $response = (new JsonResponse())
                ->setData($data)
                ->setStatusCode(Response::HTTP_UNPROCESSABLE_ENTITY);

            $event->setResponse($response);
        }
    }
}
