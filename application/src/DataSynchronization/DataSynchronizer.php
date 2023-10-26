<?php

declare(strict_types=1);

namespace Gesparo\ES\DataSynchronization;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Gesparo\ES\ElasticSearch\BulkFileDataGetter;

class DataSynchronizer
{
    private BulkFileDataGetter $bulkFileDataGetter;
    private ChunkDataSender $chunkDataSender;

    public function __construct(BulkFileDataGetter $bulkFileDataGetter, ChunkDataSender $chunkDataSender)
    {
        $this->bulkFileDataGetter = $bulkFileDataGetter;
        $this->chunkDataSender = $chunkDataSender;
    }

    /**
     * @throws DataSynchronizationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws \JsonException
     */
    public function sync(): void
    {
        foreach ($this->bulkFileDataGetter->get() as $line) {
            if (is_bool($line)) {
                continue;
            }

            $this->chunkDataSender->push($this->createValueObject($line));
        }

        $this->chunkDataSender->finish();
    }

    /**
     * @throws DataSynchronizationException
     * @throws \JsonException
     */
    private function createValueObject(string $line): FileLine
    {
        $data = json_decode($line, true, 512, JSON_THROW_ON_ERROR);

        return new FileLine($data);
    }
}