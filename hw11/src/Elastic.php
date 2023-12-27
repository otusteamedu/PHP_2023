<?php
declare(strict_types=1);

namespace Elena\Hw11;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Elasticsearch\Common\Exceptions\ElasticsearchException;
use Elasticsearch\Common\Exceptions\NoNodesAvailableException;

class Elastic
{
    public Client $client;

    public static function client()
    {
        $client = ClientBuilder::create()
            ->setHosts(['https://localhost:9200'])
            ->setSSLVerification(false)
            ->setBasicAuthentication('elastic', 'E4_F2dC_OmRjaPyz8srG')
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
                  $elastic = new Elastic();
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


    public function search_param($search_title = "" , $search_price = null)
    {
       $param = [
            'scroll' => '5m',
            'index' => 'otus-shop',
            'size' => 100,
            'body' =>[
               'query' => [
                    'bool' => [
                        'must' => [
                            ['match' => [
                                'title' => [
                                    'query' => $search_title,
                                    'fuzziness' => 'auto'
                                ]
                            ]
                            ]
                        ],
                        'filter' => [
                            [ 'range' => [
                                'price' => [ 'lte'=> $search_price]
                            ]],
                            ['nested'=>[
                                'path' => 'stock',
                                'query' => [
                                    'bool' => [
                                        'filter' => [
                                            ['range' => [
                                                'stock.stock' => [ 'gte' => 1]
                                            ]
                                            ]
                                        ]
                                    ]
                                ]
                            ]
                            ]
                        ]
                    ]
                ]
            ]
        ];
        return $param;
    }

    public function search_book($search_word, $search_price)
    {
        if($this->client =Elastic::client()){
            $search_param = Elastic::search_param($search_word, $search_price);

            $response = $this->client->search($search_param);

            foreach ($response['hits']['hits'] as $hit) {
                echo ' ** ' ;
                echo $hit['_source']['sku']." " ;
                echo $hit['_source']['title']." " ;
                echo $hit['_source']['price']." ";
                echo $hit['_source']['category']." ";
                echo ' ';
            }
        }

    }
}

