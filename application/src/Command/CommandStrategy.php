<?php

declare(strict_types=1);

namespace Gesparo\ES\Command;

use Elastic\Elasticsearch\Client;
use Gesparo\ES\AppException;
use Gesparo\ES\ArgvManager;
use Gesparo\ES\ElasticSearch\Searcher;
use Gesparo\ES\EnvManager;
use Gesparo\ES\OutputHelper;
use Gesparo\ES\PathHelper;
use Gesparo\ES\Search\Price;
use Gesparo\ES\Search\Title;
use Gesparo\ES\Service\BulkSynchronizationService;
use Gesparo\ES\Service\CreateIndexService;
use Gesparo\ES\Service\DeleteIndexService;
use Gesparo\ES\Service\SearchService;

class CommandStrategy
{
    private const BULK_COMMAND = 'bulk';
    private const SEARCH_COMMAND = 'search';
    private const DELETE_INDEX_COMMAND = 'delete-index';
    private const CREATE_INDEX_COMMAND = 'create-index';

    private ArgvManager $argvManager;
    private EnvManager $envManager;
    private Client $elasticClient;

    public function __construct(ArgvManager $argvManager, EnvManager $envManager, Client $elasticClient)
    {
        $this->argvManager = $argvManager;
        $this->envManager = $envManager;
        $this->elasticClient = $elasticClient;
    }

    /**
     * @throws AppException
     */
    public function get(): RunCommandInterface
    {
        $command = $this->argvManager->getByPosition(1);

        switch ($command) {
            case self::BULK_COMMAND:
                $pathToBulkFile = PathHelper::getInstance()->getRootPath() . $this->envManager->getPathToElasticBulkFile();
                $service = (new BulkSynchronizationService($this->elasticClient, $pathToBulkFile));

                return new BulkInitializationCommand($service);
            case self::SEARCH_COMMAND:
                $searcher = new Searcher($this->elasticClient, $this->envManager->getElasticIndex());
                $price = new Price((int) $this->argvManager->getByPosition(2));
                $title = new Title($this->argvManager->getByPosition(3));
                $outputHelper = new OutputHelper();
                $service = new SearchService($searcher, $price, $title, $outputHelper);

                return new SearchCommand($service);
            case self::DELETE_INDEX_COMMAND:
                $service = new DeleteIndexService($this->elasticClient, $this->envManager->getElasticIndex());
                return new DeleteIndexCommand($service);
            case self::CREATE_INDEX_COMMAND:
                $service = new CreateIndexService($this->elasticClient, $this->envManager->getElasticIndex());
                return new CreateIndexCommand($service);
            default:
                return new HelpCommand();
        }
    }
}
