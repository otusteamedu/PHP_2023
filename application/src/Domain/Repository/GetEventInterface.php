<?php

declare(strict_types=1);

namespace Gesparo\HW\Domain\Repository;

use Gesparo\HW\Domain\Entity\Event;
use Gesparo\HW\Domain\List\GetConditionList;

interface GetEventInterface
{
    public function get(GetConditionList $list): ?Event;
}
