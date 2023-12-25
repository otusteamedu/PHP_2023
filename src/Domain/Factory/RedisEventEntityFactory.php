<?php

declare(strict_types=1);

namespace HW11\Elastic\Domain\Factory;

use HW11\Elastic\Domain\AbstractEventEntity;
use HW11\Elastic\Domain\RedisEventEntity;
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
