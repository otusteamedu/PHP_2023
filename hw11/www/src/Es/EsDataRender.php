<?php

namespace Shabanov\Otusphp\Es;

class EsDataRender
{
    private array $data = [];
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function showBooksTable(): void
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
