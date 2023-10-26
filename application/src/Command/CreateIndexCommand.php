<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Gesparo\ES\ElasticSearch\ClientCreator;
use Gesparo\ES\EnvCreator;
use Gesparo\ES\PathHelper;
use Gesparo\ES\Service\CreateIndexService;

class CreateIndexCommand extends BaseCommand
{
    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws MissingParameterException
     * @throws ServerResponseException
     */
    public function run(): void
    {
        $envManager = (new EnvCreator(PathHelper::getInstance()->getEnvPath()))->create();
        $elasticClient = (new ClientCreator(
            $envManager->getElasticPassword(),
            $envManager->getPathToElasticSearchCertificate()
        ))->create();

        (new CreateIndexService($elasticClient, $envManager->getElasticIndex()))->createIndex();

        $this->outputHelper->success('Index was successfully deleted');
    }
}