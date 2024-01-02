<?php

namespace DanielPalm\Library;

use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchClientWrapper
{
    private $config;

    public function __construct(Configuration $config)
    {
        $this->config = $config;
    }

    public function buildClient()
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
