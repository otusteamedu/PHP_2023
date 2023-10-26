<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Gesparo\ES\AppException;
use Gesparo\ES\ArgvManager;
use Gesparo\ES\ElasticSearch\ClientCreator;
use Gesparo\ES\ElasticSearch\Searcher;
use Gesparo\ES\EnvCreator;
use Gesparo\ES\PathHelper;
use Gesparo\ES\Search\Price;
use Gesparo\ES\Search\Title;
use Gesparo\ES\Service\SearchService;

class SearchCommand extends BaseCommand
{
    private ArgvManager $argvManager;

    public function __construct(ArgvManager $argvManager)
    {
        parent::__construct();

        $this->argvManager = $argvManager;
    }

    /**
     * @throws AuthenticationException
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws AppException
     */
    public function run(): void
    {
        $envManager = (new EnvCreator(PathHelper::getInstance()->getEnvPath()))->create();
        $elasticClient = (new ClientCreator(
            $envManager->getElasticPassword(),
            $envManager->getPathToElasticSearchCertificate()
        ))->create();

        (new SearchService(
            new Searcher($elasticClient, $envManager->getElasticIndex()),
            new Price((int) $this->argvManager->getByPosition(2)),
            new Title($this->argvManager->getByPosition(3)),
            $this->outputHelper
        ))->makeSearch();
    }
}