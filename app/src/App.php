<?php

declare(strict_types=1);

namespace Imitronov\Hw11;

use DI\Container;
use DI\ContainerBuilder;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Exception;
use Imitronov\Hw11\Application\Repository\ProductRepository;
use Imitronov\Hw11\Infrastructure\Command\SearchBooksCommand;
use Imitronov\Hw11\Infrastructure\Command\ImportProductsToElasticCommand;
use Imitronov\Hw11\Infrastructure\Component\Transformer\ProductTransformer;
use Imitronov\Hw11\Infrastructure\Repository\EsProductRepository;
use Symfony\Component\Console\Application;
use Symfony\Component\Dotenv\Dotenv;

final class App
{
    private Container $container;

    private Application $console;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        (new Dotenv())->load(dirname(__DIR__) . '/.env');
        $containerBuilder = new ContainerBuilder();
        $containerBuilder->useAutowiring(true);
        $containerBuilder->addDefinitions([
            Client::class => static fn () => ClientBuilder::create()
                ->setHosts([$_ENV['ES_HOST']])
                ->setBasicAuthentication($_ENV['ES_USERNAME'], $_ENV['ES_PASSWORD'])
                ->build(),
            ProductRepository::class => static fn (Container $container) => new EsProductRepository(
                $container->get(Client::class),
                $container->get(ProductTransformer::class),
                $_ENV['ES_INDEX'],
            ),
            ImportProductsToElasticCommand::class => static fn (Container $container) => new ImportProductsToElasticCommand(
                $container->get(Client::class),
                $_ENV['ES_INDEX'],
                $_ENV['ES_INDEX_CONFIG_PATH'],
            ),
        ]);
        $this->container = $containerBuilder->build();
        $this->console = new Application();
        $this->console->add($this->container->get(SearchBooksCommand::class));
        $this->console->add($this->container->get(ImportProductsToElasticCommand::class));
    }

    /**
     * @throws Exception
     */
    public function run(): void
    {
        $this->console->run();
    }
}
