<?php

declare(strict_types=1);

namespace App\Domain;

use Ehann\RediSearch\Index;
use Ehann\RediSearch\IndexInterface;
use Ehann\RedisRaw\RedisRawClientInterface;

class RedisEventEntity extends AbstractEventEntity
{
    private IndexInterface $event;

    public function __construct(
        readonly RedisRawClientInterface $client,
        readonly string $eventName
    ) {
        $this->event = new Index($this->client, $this->eventName);
    }

    public function getEvent(): IndexInterface
    {
        return $this->event;
    }
}
