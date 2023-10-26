<?php

declare(strict_types=1);

namespace Gesparo\ES\ElasticSearch;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;

class ClientCreator
{
    private string $password;
    private string $pathToCertificate;

    public function __construct(string $password, string $pathToCertificate)
    {
        $this->password = $password;
        $this->pathToCertificate = $pathToCertificate;
    }

    /**
     * @throws AuthenticationException
     */
    public function create(): Client
    {
        return ClientBuilder::create()
            ->setHosts(['https://es01:9200'])
            ->setBasicAuthentication('elastic', $this->password)
            ->setCABundle($this->pathToCertificate)
            ->build();
    }
}