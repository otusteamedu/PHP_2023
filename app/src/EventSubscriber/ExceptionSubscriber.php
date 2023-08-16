<?php

declare(strict_types=1);

namespace App\EventSubscriber;

use ErrorException;
use App\Exception\UserExceptionInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\{Event\ExceptionEvent, KernelEvents};
use Symfony\Component\Serializer\SerializerInterface;

class ExceptionSubscriber implements EventSubscriberInterface
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => [
                ['processException', -10],
            ],
        ];
    }

    public function processException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        $errorMessage = null;

        if ($exception instanceof ErrorException) {
            return;
        }

        if ($exception instanceof UserExceptionInterface) {
            $errorMessage['userMessage'] = $exception->getUserMessage();
        }

        $errorMessage['errorMessage'] = $exception->getMessage();

        $event->setResponse(
            new Response($this->serializer->serialize($errorMessage, 'json'), Response::HTTP_BAD_REQUEST)
        );
    }
}