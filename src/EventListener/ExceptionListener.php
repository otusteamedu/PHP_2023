<?php
declare(strict_types=1);

namespace App\EventListener;

use App\Exception\ValidationException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class ExceptionListener implements EventSubscriberInterface
{

    public static function getSubscribedEvents():array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 2]
        ];
    }

    /**
     * @throws ValidationException
     */
    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if($exception instanceof NotFoundHttpException){
            $event->setResponse(new JsonResponse(['description' => 'object not found']));
        }

        if (
            $exception instanceof HttpException
            && $exception->getStatusCode() === Response::HTTP_UNPROCESSABLE_ENTITY
        ){
            throw new ValidationException($exception->getPrevious()->getViolations());
        }
    }
}
