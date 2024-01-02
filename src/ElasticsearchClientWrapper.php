<?php
declare(strict_types=1);

namespace DanielPalm\Library;

use Elastic\Elasticsearch\ClientBuilder;
use Elastic\Elasticsearch\Exception\AuthenticationException;
use Elastic\Elasticsearch\Client;

class ElasticsearchClientWrapper
{

    private Configuration $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    /**
     * @throws AuthenticationException
     */
    public function buildClient(): Client
    {
        $hosts = [$this->config->get('ELASTICSEARCH_HOST')];
        $username = $this->config->get('ELASTIC_USERNAME', 'elastic');
        $password = $this->config->get('ELASTIC_PASSWORD', 'your_elastic_password');

        return ClientBuilder::create()
            ->setHosts($hosts)
            ->setBasicAuthentication($username, $password)
            ->build();
    }
}
