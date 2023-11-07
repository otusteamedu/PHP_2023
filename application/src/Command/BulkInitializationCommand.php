<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Gesparo\ES\AppException;
use Gesparo\ES\DataSynchronization\DataSynchronizationException;
use Gesparo\ES\Service\BulkSynchronizationService;

class BulkInitializationCommand extends BaseCommand
{
    private BulkSynchronizationService $bulkSynchronizationService;

    public function __construct(BulkSynchronizationService $bulkSynchronizationService)
    {
        parent::__construct();
        $this->bulkSynchronizationService = $bulkSynchronizationService;
    }

    /**
     * @throws AppException
     * @throws DataSynchronizationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws \JsonException
     */
    public function run(): void
    {
        $this->bulkSynchronizationService->makeSynchronization();

        $this->outputHelper->success('Bulk file was successfully initialized');
    }
}
