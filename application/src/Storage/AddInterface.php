<?php

declare(strict_types=1);

namespace Gesparo\HW\Storage;

use Gesparo\HW\Event\EventList;

interface AddInterface
{
    public function add(EventList $list): void;
}
