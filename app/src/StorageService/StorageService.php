<?php

declare(strict_types=1);

namespace Neunet\App\StorageService;

use BadMethodCallException;
use Neunet\App\Models\Event;
use Neunet\App\StorageService\Service\ServiceInterface;

class StorageService
{
    public function handle(ServiceInterface $service): bool|string|null
    {
        return match ($_REQUEST['method']) {
            'add' => $service->addEvent(new Event((int)$_REQUEST['priority'], json_decode($_REQUEST['conditions'], true))),
            'clear' => $service->clearAllEvents(),
            'get' => $service->getEvent(json_decode($_REQUEST['params'], true))->print(),
            default => throw new BadMethodCallException('method ' . $_REQUEST['method'] . ' does not exist')
        };
    }
}
