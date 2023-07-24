<?php

declare(strict_types=1);

namespace Desaulenko\Hw11\Elastic;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class Controller
{
    protected static ?Client $client = null;
    protected string $index;

    public function __construct(string $index)
    {
        if (!self::$client) {
            try {
                self::$client = ClientBuilder::create()
                    ->setHosts([getenv('ELASTIC_HOST')])
                    ->setSSLVerification(false)
                    ->setCABundle(realpath($_SERVER['DOCUMENT_ROOT']) . '/http_ca.crt')
                    ->setBasicAuthentication(getenv('ELASTIC_USER'), getenv('ELASTIC_PASSWORD'))
                    ->build();

            } catch (\Exception $exception) {
            }
        }
        $this->index = $index;
    }

    public function get(string $id): string
    {
        try {
            return self::$client->get([
                'index' => $this->index,
                'id' => $id
            ])->asString();
        } catch (\Exception $exception) {
            return $exception->getMessage();
        }
    }

    public function search(array $body): array
    {
        try {
            return self::$client->search([
                'index' => $this->index,
                $body
            ])->asArray();
        } catch (\Exception $exception) {
            return ['error' => $exception->getMessage()];
        }
    }

}