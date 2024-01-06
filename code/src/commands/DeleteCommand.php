<?php

namespace Radovinetch\Hw11\commands;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class DeleteCommand extends Command
{
    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     * @throws MissingParameterException
     */
    public function run(array $options): void
    {
        $this->storage->deleteIndex();
    }
}