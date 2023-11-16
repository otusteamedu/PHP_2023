<?php

declare(strict_types=1);

namespace Gesparo\HW\Service;

use Gesparo\HW\Event\Event;
use Gesparo\HW\Event\GetConditionList;
use Gesparo\HW\Storage\GetInterface;

class GetService
{
    private GetConditionList $list;
    private GetInterface $storage;

    public function __construct(GetConditionList $list, GetInterface $storage)
    {
        $this->list = $list;
        $this->storage = $storage;
    }

    public function get(): ?Event
    {
        return $this->storage->get($this->list);
    }
}
