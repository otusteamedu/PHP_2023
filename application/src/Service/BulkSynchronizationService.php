<?php

declare(strict_types=1);

namespace Gesparo\ES\Service;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Gesparo\ES\AppException;
use Gesparo\ES\DataSynchronization\ChunkDataSender;
use Gesparo\ES\DataSynchronization\DataSynchronizationException;
use Gesparo\ES\DataSynchronization\DataSynchronizer;
use Gesparo\ES\ElasticSearch\BulkFileDataGetter;

class BulkSynchronizationService
{
    private Client $elasticClient;
    private string $pathToBulkFile;

    public function __construct(Client $elasticClient, string $pathToBulkFile)
    {
        $this->elasticClient = $elasticClient;
        $this->pathToBulkFile = $pathToBulkFile;
    }

    /**
     * @throws AppException
     * @throws DataSynchronizationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws \JsonException
     */
    public function makeSynchronization(): void
    {
        $this->checkBulkFileIsValid();

        $bulkFileReader = new BulkFileDataGetter($this->openBulkFile());
        $chunkDataSender = new ChunkDataSender($this->elasticClient);

        (new DataSynchronizer($bulkFileReader, $chunkDataSender))->sync();
    }

    /**
     * @throws AppException
     */
    private function checkBulkFileIsValid(): void
    {
        if (!file_exists($this->pathToBulkFile)) {
            throw AppException::cannotFindElasticBulkFile($this->pathToBulkFile);
        }

        if (!is_readable($this->pathToBulkFile)) {
            throw AppException::cannotReadBulkFile($this->pathToBulkFile);
        }
    }

    /**
     * @return resource
     * @throws AppException
     */
    private function openBulkFile()
    {
        $fileDescriptor = fopen($this->pathToBulkFile, 'rb');

        if ($fileDescriptor === false) {
            throw AppException::cannotOpenBulkFile($this->pathToBulkFile);
        }

        return $fileDescriptor;
    }
}
