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
use Gesparo\ES\Service\DeleteIndexService;

class DeleteIndexCommand extends BaseCommand
{
    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function run(): void
    {
        $envManager = (new EnvCreator(PathHelper::getInstance()->getEnvPath()))->create();
        $elasticClient = (new ClientCreator(
            $envManager->getElasticPassword(),
            $envManager->getPathToElasticSearchCertificate()
        ))->create();

        (new DeleteIndexService($elasticClient, $envManager->getElasticIndex()))->deleteIndex();

        $this->outputHelper->success('Index was successfully deleted');
    }
}