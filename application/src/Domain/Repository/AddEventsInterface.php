<?php

declare(strict_types=1);

namespace Gesparo\HW\Domain\Repository;

use Gesparo\HW\Domain\List\EventList;

interface AddEventsInterface
{
    public function add(EventList $list): void;
}
