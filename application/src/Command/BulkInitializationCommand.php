<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Gesparo\ES\AppException;
use Gesparo\ES\DataSynchronization\DataSynchronizationException;
use Gesparo\ES\ElasticSearch\ClientCreator;
use Gesparo\ES\EnvCreator;
use Gesparo\ES\PathHelper;
use Gesparo\ES\Service\BulkSynchronizationService;

class BulkInitializationCommand extends BaseCommand
{
    /**
     * @throws AppException
     * @throws AuthenticationException
     * @throws DataSynchronizationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws \JsonException
     */
    public function run(): void
    {
        $envManager = (new EnvCreator(PathHelper::getInstance()->getEnvPath()))->create();
        $elasticClient = (new ClientCreator(
            $envManager->getElasticPassword(),
            $envManager->getPathToElasticSearchCertificate()
        ))->create();
        $pathToBulkFile = PathHelper::getInstance()->getRootPath() . $envManager->getPathToElasticBulkFile();

        (new BulkSynchronizationService($elasticClient, $pathToBulkFile))->makeSynchronization();

        $this->outputHelper->success('Bulk file was successfully initialized');
    }
}