<?php
declare(strict_types=1);

namespace WorkingCode\Hw11\Command;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use WorkingCode\Hw11\Service\ElasticsearchService;

class SearchCommand implements Command
{
    public const OPTIONS = [
        'search:',
        'price_max::',
        'category::',
        'stock_min::',
    ];

    private const INDEX_NAME = 'otus-shop';

    public function __construct(
        private readonly ElasticsearchService $ESService,
        private readonly array                $options,
    ) {
    }

    /**
     * @throws ServerResponseException
     * @throws ClientResponseException
     */
    public function execute(): int
    {
        $result = $this->ESService->search($this->options, static::INDEX_NAME);

        if (count($result['hits']['hits']) == 0) {
            echo "Ничего не найдено\n";
        } else {
            $this->printResult($result);
        }

        return static::SUCCESS;
    }

    private function printResult(array $searchResult): void
    {
        $columnWidth1 = 64;
        $columnWidth2 = 8;
        $columnWidth3 = 24;
        $columnWidth4 = 8;
        $columnWidth5 = 30;

        $rowSeparator = "| " . str_repeat('-', $columnWidth1) . " | "
            . str_repeat('-', $columnWidth2) . " | "
            . str_repeat('-', $columnWidth3) . " | "
            . str_repeat('-', $columnWidth4) . " | "
            . str_repeat('-', $columnWidth5) . " |\n";

        echo $rowSeparator;
        echo "| " . 'Название' . str_repeat(' ', $columnWidth1 - mb_strlen('Название')) . " | ";
        echo 'Артикул' . str_repeat(' ', $columnWidth2 - mb_strlen('Артикул')) . " | ";
        echo 'Категория' . str_repeat(' ', $columnWidth3 - mb_strlen('Категория')) . " | ";
        echo 'Цена' . str_repeat(' ', $columnWidth4 - mb_strlen('Цена')) . " | ";
        echo 'Наличие' . str_repeat(' ', $columnWidth5 - mb_strlen('Наличие')) . " |\n";
        echo $rowSeparator;

        foreach ($searchResult['hits']['hits'] as $row) {
            $rowData = $row['_source'];

            $stockStr = implode(',',
                array_map(
                    static fn (array $row) => $row['shop'] . ': ' . $row['stock'] . 'шт',
                    $rowData['stock']
                ));

            echo "| " . $rowData['title'] . str_repeat(' ', $columnWidth1 - mb_strlen($rowData['title'])) . " | ";
            echo $rowData['sku'] . str_repeat(' ', $columnWidth2 - mb_strlen($rowData['sku'])) . " | ";
            echo $rowData['category'] . str_repeat(' ', $columnWidth3 - mb_strlen($rowData['category'])) . " | ";
            echo $rowData['price'] . str_repeat(' ', $columnWidth4 - mb_strlen((string)$rowData['price'])) . " | ";
            echo $stockStr . str_repeat(' ', $columnWidth5 - mb_strlen($stockStr)) . " |\n";
        }

        echo $rowSeparator;
    }
}
