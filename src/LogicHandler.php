<?php

namespace HW11\Elastic;

class LogicHandler
{
    public function handleLogic($searchTerm, $category, $price, $stockQuantity)
    {
        $app = new SearchExecutor('https://localhost:9200', 'elastic', 'pass1234');
        $searchResults = $app->search([
            'title'    => $searchTerm,
            'category' => $category,
            'price'    => $price,
            'stock'    => $stockQuantity,
        ]);
        $this->displayResults($searchResults);
    }
    public function displayResults(array $searchResults)
    {
        $table = new LucidFrame\Console\ConsoleTable();
        $table->setHeaders(['#', 'title', 'sku', 'category', 'price', 'stocks']);
        foreach ($searchResults['hits'] as $key => $hit) {
            $data        = $hit['_source'];
            $stockInline = '';
            foreach ($data['stock'] as $stock) {
                $stockInline .= "{$stock['shop']} {$stock['stock']} шт.; ";
            }
            $table->addRow([$key, $data['title'], $data['sku'], $data['category'], $data['price'], $stockInline]);
        }
        $table->setIndent(4)->display();
    }
}
