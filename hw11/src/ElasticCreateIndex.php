<?php
declare(strict_types=1);

namespace Elena\Hw11;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\ElasticsearchException;
use Elasticsearch\Common\Exceptions\NoNodesAvailableException;

class ElasticCreateIndex
{
    public Client $client;
    public $host;
    public $user;
    public $password;


    public function __construct($host,$user,$password)
    {
        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        echo 'host '.$this->host;
    }

    public function client()
    {
        $client = ClientBuilder::create()
            ->setHosts([$this->host])
            ->setSSLVerification(false)
            ->setBasicAuthentication($this->user, $this->password)
            ->build();

        try {
            $result = $client->info();
            print_r($result);
            return $client;
        } catch (NoNodesAvailableException $e) {
            printf("The node is offline: %s\n", $e->getMessage());
            return false;
        } catch (ElasticsearchException $e) {
            printf("Error: %s\n", $e->getMessage());
            return false;
        }


    }

    public function createBase()
    {
        try {
            $elastic = new ElasticCreateIndex('https://localhost:9200','elastic','E4_F2dC_OmRjaPyz8srG');
            $elastic->deleteIndex();
            $elastic->createIndex();
        } catch (Exception $e) {
            return ("400 Bad Request. " . $e->getMessage());
        }
    }


    public function deleteIndex()
    {
        try {
            $this->client->indices()->delete(['index' => 'otus-shop']);
            print_r('deleted' . '<\br>');
        } catch (ElasticsearchException $e) {
            printf("Error: %s\n", $e->getMessage());
        }
    }

    public function createIndex()
    {
        try {
            $this->client->indices()->create([
                'index' => 'otus-shop',
                'body' => $this->map(),
            ]);
            print_r('created' . '<\br>');
        } catch (ElasticsearchException $e) {
            printf("Error: %s\n", $e->getMessage());
        }

    }

    private function map()
    {
        return [
            "settings" => [
                "analysis" => [
                    "filter" => [
                        "ru_stop" => [
                            "type" => "stop",
                            "stopwords" => "_russian_",
                        ],
                        "ru_stemmer" => [
                            "type" => "stemmer",
                            "language" => "russian",
                        ],
                    ],
                    "analyzer" => [
                        "lang_russian" => [
                            "tokenizer" => "standard",
                            "filter" => [
                                "lowercase",
                                "ru_stop",
                                "ru_stemmer",
                            ],
                        ],
                    ],
                ],
            ],
            "mappings" => [
                "properties" => [
                    "sku" => [
                        "type" => "keyword",
                    ],
                    "title" => [
                        "type" => "text",
                        "analyzer" => "lang_russian",
                    ],
                    "category" => [
                        "type" => "keyword",
                    ],
                    "price" => [
                        "type" => "long",
                    ],
                    "stock" => [
                        "type" => "nested",
                        "properties" => [
                            "shop" => [
                                "type" => "keyword",
                            ],
                            "stock" => [
                                "type" => "long",
                            ],
                        ],
                    ],
                ],
            ],
        ];
    }


}


