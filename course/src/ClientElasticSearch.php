<?php

namespace Cases\Php2023;
use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;

class ClientElasticSearch
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @var string
     */
    private string $localHost = '172.17.0.1';

    /**
     * @var string
     */
    private string $localPort = '9200';

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    public function __construct()
    {
        $address = $this->createAddress($this->getLocalHost(), $this->getLocalPort());
        $this->client = ClientBuilder::create()
            ->setSSLVerification(false)
            ->setHosts([$address])->build();
    }

    /**
     * @param $localHost
     * @param $localPort
     * @return string
     */
    private function createAddress($localHost, $localPort): string
    {
        return sprintf('%s:%s',$localHost,$localPort);
    }

    /**
     * @return string
     */
    public function getLocalHost(): string
    {
        return $this->localHost;
    }

    /**
     * @return string
     */
    public function getLocalPort(): string
    {
        return $this->localPort;
    }
}