<?php

declare(strict_types=1);

namespace Gesparo\ES;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Gesparo\ES\Command\CommandStrategy;
use Gesparo\ES\ElasticSearch\ClientCreator;

class App
{
    private string $rootPath;
    private array $argv;

    public function __construct(string $rootPath, array $argv)
    {
        $this->rootPath = $rootPath;
        $this->argv = $argv;
    }

    /**
     * @throws AuthenticationException
     */
    public function run(): void
    {
        $this->initPathHelper();
        $this->initArgvManager();

        $envManager = $this->getEnvManager();
        $elasticClient = $this->getElasticClient($envManager);

        (new CommandStrategy(ArgvManager::getInstance(), $envManager, $elasticClient))->get()->run();
    }

    private function initPathHelper(): void
    {
        PathHelper::initInstance($this->rootPath);
    }

    private function initArgvManager(): void
    {
        ArgvManager::initInstance($this->argv);
    }

    private function getEnvManager(): EnvManager
    {
        return (new EnvCreator(PathHelper::getInstance()->getEnvPath()))->create();
    }

    /**
     * @throws AuthenticationException
     */
    private function getElasticClient(EnvManager $envManager): Client
    {
        return (new ClientCreator(
            $envManager->getElasticPassword(),
            $envManager->getPathToElasticSearchCertificate()
        ))->create();
    }
}
