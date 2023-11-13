<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Storage;

use Gesparo\HW\Domain\Repository\AddEventsInterface;
use Gesparo\HW\Domain\Repository\ClearEventsInterface;
use Gesparo\HW\Domain\Repository\GetEventInterface;

abstract class BaseStorageFacade implements AddEventsInterface, GetEventInterface, ClearEventsInterface
{
}
