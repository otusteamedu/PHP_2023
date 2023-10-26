<?php

declare(strict_types=1);

namespace App\Storage\redis;

use Ehann\RediSearch\AbstractIndex;
use Ehann\RediSearch\Index as EhannIndex;
use Ehann\RedisRaw\RedisRawClientInterface;

class Index
{
    public function __construct(
        readonly RedisRawClientInterface $client,
        readonly string                  $indexName
    ) {
    }

    public function createIndex(): AbstractIndex
    {
        return (new EhannIndex($this->client, $this->indexName))
            ->addNumericField('priority')
            ->addTextField('event')
            ->addNumericField('param1')
            ->addNumericField('param2')
            ->create();
    }
}