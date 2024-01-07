<?php

namespace Radovinetch\Hw11\commands;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use JsonException;

class CreateCommand extends Command
{
    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     * @throws JsonException
     */
    public function run(array $options): void
    {
        echo 'Создаем индекс и наполняем его...' . PHP_EOL;

        $this->storage->createIndex();
        $this->storage->bulk();

        echo 'Индекс создан!' . PHP_EOL;
    }
}