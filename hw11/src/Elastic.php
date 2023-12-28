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

}

