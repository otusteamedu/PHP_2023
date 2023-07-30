<?php

namespace IilyukDmitryi\App\Application\UseCase;

use Exception;
use IilyukDmitryi\App\Application\Contract\Storage\EventStorageInterface;
use IilyukDmitryi\App\Application\Dto\CheckStatusEventRequest;
use IilyukDmitryi\App\Application\Dto\CheckStatusEventResponse;

class CheckStatusRequestUseCase
{

    public function __construct(protected readonly EventStorageInterface $eventStorage)
    {
    }

    /**
     * @throws Exception
     */
    public function exec(CheckStatusEventRequest $checkStatusEventRequest): CheckStatusEventResponse
    {
        $uuid = $checkStatusEventRequest->getUuid();
        $event = $this->eventStorage->get($uuid);
        if (is_null($event)) {
            throw new Exception("No event found");
        }
        if ($event->isDone()) {
            $message = 'Запрос выполнен. Результат отправлен вам на Емаил';
        } else {
            $message = "Запрос ожидает обработки";
        }
        return new CheckStatusEventResponse($message);
    }
}
