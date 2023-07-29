<?php

declare(strict_types=1);

namespace VLebedev\BookShop;

use Elastic\Elasticsearch\ClientBuilder;

class App
{
    public function execute()
    {
        $client = ClientBuilder::create()
            ->setHosts(['https://localhost:9200'])
            ->setBasicAuthentication('elastic', '11pm+TAuP2XqfaxsThBe')
            ->setCABundle(dirname(__DIR__) . '/http_ca.crt')
            ->build();

        $response = $client->info();
        print_r($response['version']);
    }
}