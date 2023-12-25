<?php

declare(strict_types=1);

namespace HW11\Elastic\Domain\Factory;

use HW11\Elastic\Domain\AbstractEventEntity;

abstract class AbstractEventEntityFactory
{
    abstract public function createEvent(): AbstractEventEntity;
}
