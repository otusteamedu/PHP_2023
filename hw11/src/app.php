<?php

namespace Elena\Hw11;

use Exception;
use http\Client\Request;


class App
{
    function __construct($argv){
        $this->argv = $argv;

        foreach($argv as $one){
            $args = explode('**',$one);
            switch($args[0]){
                case "-p":
                    $this->search_price = $args[1];
                    break;
                case "-w":
                    $this->search_word = $args[1];
                    break;
                case "-h":
                    $this->host = $args[1];
                    break;
                case "-u":
                    $this->user = $args[1];
                    break;
                case "-pass":
                    $this->password = $args[1];
                    break;
            }
        }
   }


   function run()
    {

          $elastic = new Elastic($this->host, $this->user, $this->password);

        if($this->client = $elastic->client() ){
            $search_param = $elastic->search_param($this->search_word, $this->search_price);

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

