<?php

declare(strict_types=1);

namespace Vp\App\Event;

use Vp\App\DTO\Message;
use Vp\App\Exceptions\AddEventFailed;
use Vp\App\Result\ResultAdd;
use Vp\App\Storage\StorageInterface;
use Vp\App\Storage\StorageManager;

class EventAdd
{
    use StorageManager;

    private StorageInterface $storage;

    public function __construct()
    {
        $this->storage = $this->getStorage();
    }
    public function work(AddParams $addParams): ResultAdd
    {
        $strEvent = $this->getStrEvent($addParams);
        $params = $this->getEventParams($addParams);

        try {
            $this->storage->add(md5($strEvent), $params, $strEvent);
            return new ResultAdd(true, Message::SUCCESS_CREATE_EVENT);
        } catch (AddEventFailed $e) {
            return new ResultAdd(false, $e->getMessage());
        }
    }

    private function getStrEvent(AddParams $addParams): string
    {
        $event['priority'] = $addParams->getPriority();
        $event['conditions'] = $addParams->getParams();
        $event['event'] = $addParams->getEvent();

        return json_encode($event);
    }

    private function getEventParams(AddParams $addParams): string
    {
        return implode(' ', $addParams->getParams());
    }
}
