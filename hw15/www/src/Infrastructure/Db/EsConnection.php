<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Infrastructure\Db;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use Elastic\Transport\Exception\NoNodeAvailableException;
use Exception;
use Shabanov\Otusphp\Infrastructure\Db\ConnectionInterface;

class EsConnection implements ConnectionInterface
{
    private static ?self $instance = null;
    private Client $client;
    private function __construct(string $esHost, string $esUser, string $esPass)
    {
        $this->client = ClientBuilder::create()
            ->setHosts(['http://'.$esHost.':9200/'])
            ->setBasicAuthentication($esUser, $esPass)
            ->setSSLVerification(false)
            ->build();
    }

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self($_ENV['elasticHost'], $_ENV['elasticUser'], $_ENV['elasticPass']);
        }
        return self::$instance;
    }

    /**
     * @throws Exception
     */
    public function getClient(): ?Client
    {
        try {
            if (!empty($this->client->info())) {
                return $this->client;
            }
        } catch (NoNodeAvailableException|ServerResponseException|ClientResponseException $e) {
            throw new Exception($e->getMessage());
        }
        return null;
    }
}
