<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Elastic\Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()
    ->setHosts(['https://localhost:9200'])
    ->setBasicAuthentication('elastic', '123456')
    ->setCABundle('http_ca.crt')
    ->build();

// Info API
$response = $client->info();

echo $response['version']['number'] . "\n"; // 8.0.0
echo $response->getStatusCode() . "\n"; // 200
echo $response->getBody(); // Response body in JSON