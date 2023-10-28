<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\AbstractEventEntity;

abstract class AbstractEventEntityFactory
{
    public abstract function createEvent(): AbstractEventEntity;
}
