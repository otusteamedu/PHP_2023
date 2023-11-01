<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage;

use Gesparo\HW\Event\Event;
use Gesparo\HW\Event\GetConditionList;

interface GetInterface
{
    public function get(GetConditionList $list): ?Event;
}