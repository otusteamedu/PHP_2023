<?php

namespace Shabanov\Otusphp\Es;

use Shabanov\Otusphp\Es\Interface\EsDataRender;

class EsBooksDataRender implements EsDataRender
{
    private array $data = [];
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function showTable(): void
    {
        echo 'SKU | Title | Category | Price | Shop | Stock ' . PHP_EOL;
        if (!empty($this->data)) {
            foreach ($this->data as $hit) {
                echo $hit['_source']['sku'] . ' | '
                    . $hit['_source']['title'] . ' | '
                    . $hit['_source']['category'] . ' | '
                    . $hit['_source']['price'] . ' | '
                    . PHP_EOL;
            }
        }
    }
}
