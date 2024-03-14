<?php

declare(strict_types=1);

namespace AYamaliev\hw11\Application;

class OutputResult
{
    public function __invoke($data)
    {
        foreach ($data['hits']['hits'] as $hit) {
            $this->echoLine($hit);
        }
    }

    private function echoLine($data): void
    {
        echo '|';
        echo " {$data['_source']['sku']} |";
        echo " {$data['_source']['title']} |";
        echo " {$data['_source']['category']} |";
        echo " {$data['_source']['price']} |";

        foreach ($data['_source']['stock'] as $stock) {
            echo " {$stock['shop']} - {$stock['stock']} |";
        }

        echo PHP_EOL;
    }
}
