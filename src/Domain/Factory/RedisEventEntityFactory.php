<?php

declare(strict_types=1);

namespace App\Domain\Factory;

use App\Domain\AbstractEventEntity;
use App\Domain\RedisEventEntity;
use Ehann\RedisRaw\RedisRawClientInterface;

class RedisEventEntityFactory extends AbstractEventEntityFactory
{
    public function __construct(
        readonly RedisRawClientInterface $client,
        readonly string $eventName
    ) {
    }

    public function createEvent(): AbstractEventEntity
    {
        $eventEntity = new RedisEventEntity($this->client, $this->eventName);

        return $eventEntity
            ->getEvent()
            ->addNumericField('priority')
            ->addTextField('event')
            ->addNumericField('param1')
            ->addNumericField('param2')
            ->create();
    }
}
