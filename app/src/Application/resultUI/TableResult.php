<?php

declare(strict_types=1);

namespace App\Application\resultUI;

class TableResult
{
    private array $placeSizes;

    private const HEADER_FILLER = '∙';
    private const ROW_FILLER = '·';
    private const EMPTY_SYMBOL = '';

    public function __construct()
    {
        $this->placeSizes['numb'] = 5;
        $this->placeSizes['sku'] = 7;
        $this->placeSizes['title'] = 57;
        $this->placeSizes['price'] = 9;
        $this->placeSizes['stock'] = 19;
        $this->placeSizes['category'] = 19;
    }

    public function getCategoryPlaceSize(): int
    {
        return $this->placeSizes['category'];
    }

    public function getStockPlaceSize(): int
    {
        return $this->placeSizes['stock'];
    }

    public function getPricePlaceSize(): int
    {
        return $this->placeSizes['price'];
    }

    public function getTitlePlaceSize(): int
    {
        return $this->placeSizes['title'];
    }

    public function getSkuPlaceSize(): int
    {
        return $this->placeSizes['sku'];
    }

    public function getNumbPlaceSize(): int
    {
        return $this->placeSizes['numb'];
    }

    public function showTable(array $data): void
    {
        foreach ($this->takeHeaders() as $header) {
            $this->printCLI($header);
        }

        $i = 0;
        foreach ($data as $item) {
            $this->printCLI($this->takeRow(
                ++$i,
                $item->getSku(),
                $item->getTitle(),
                $item->getCategory(),
                $item->getPrice(),
                $this->getStockToString($item->getStock())
            ));
        }
        $this->printCLI($this->takeBottom());
    }

    public function takeHeaders(): array
    {
        $numb = $this->getNumbPlaceSize();
        $sku = $this->getSkuPlaceSize();
        $title = $this->getTitlePlaceSize();
        $category = $this->getCategoryPlaceSize();
        $price = $this->getPricePlaceSize();
        $stock = $this->getStockPlaceSize();

        $counts = [$numb, $sku, $title, $category, $price, $stock];
        $count = array_sum($counts) + (count($counts) - 1);
        return [
            '',
            sprintf("*%'={$count}s*", $this::EMPTY_SYMBOL),
            sprintf(
                '|%s|%s|%s|%s|%s|%s|',
                mb_str_pad('###', $numb, $this::HEADER_FILLER, STR_PAD_BOTH),
                mb_str_pad('sku', $sku, $this::HEADER_FILLER, STR_PAD_BOTH),
                mb_str_pad('title', $title, $this::HEADER_FILLER, STR_PAD_BOTH),
                mb_str_pad('price', $price, $this::HEADER_FILLER, STR_PAD_BOTH),
                mb_str_pad('stock', $stock, $this::HEADER_FILLER, STR_PAD_BOTH),
                mb_str_pad('category', $category, $this::HEADER_FILLER, STR_PAD_BOTH)
            ),
            sprintf(
                "+%'={$numb}s+%'={$sku}s+%'={$title}s+%'={$price}s+%'={$stock}s+%'={$category}s+",
                $this::EMPTY_SYMBOL,
                $this::EMPTY_SYMBOL,
                $this::EMPTY_SYMBOL,
                $this::EMPTY_SYMBOL,
                $this::EMPTY_SYMBOL,
                $this::EMPTY_SYMBOL
            ),
        ];
    }

    public function takeRow(
        int $numb,
        string $sku,
        string $title,
        string $category,
        int $price,
        string $stock
    ): string {
        return sprintf(
            "|%s|%s|%s|%s|%s|%s|",
            sprintf("%'`{$this->getNumbPlaceSize()}s", $numb),
            //mb_str_pad($this->numb++, $this->getNumbPlaceSize(), $this::ROW_FILLER, STR_PAD_LEFT),
            sprintf("%{$this->getSkuPlaceSize()}s", $sku),
            mb_str_pad($title, $this->getTitlePlaceSize(), $this::ROW_FILLER),
            sprintf(
                "%{$this->getPricePlaceSize()}s",
                number_format($price, 2, ',', ' ')
            ),
            mb_str_pad($stock, $this->getStockPlaceSize(), $this::ROW_FILLER),
            mb_str_pad($category, $this->getCategoryPlaceSize(), $this::ROW_FILLER)
        );
    }

    public function takeBottom(): string
    {
        $numb = $this->getNumbPlaceSize();
        $sku = $this->getSkuPlaceSize();
        $title = $this->getTitlePlaceSize();
        $price = $this->getPricePlaceSize();
        $stock = $this->getStockPlaceSize();
        $category = $this->getCategoryPlaceSize();

        return sprintf(
            "*%'={$numb}s=%'={$sku}s=%'={$title}s=%'={$price}s=%'={$stock}s=%'={$category}s*",
            $this::EMPTY_SYMBOL,
            $this::EMPTY_SYMBOL,
            $this::EMPTY_SYMBOL,
            $this::EMPTY_SYMBOL,
            $this::EMPTY_SYMBOL,
            $this::EMPTY_SYMBOL
        );
    }

    private function getStockToString(array $stocks): string
    {
        return implode(
            '; ',
            array_map(
                static fn($item): string => sprintf('%s:%2d', $item['shop'], $item['stock']),
                $stocks
            )
        );
    }

    private function printCLI(string $line): void
    {
        echo $line;
        echo PHP_EOL;
    }
}
