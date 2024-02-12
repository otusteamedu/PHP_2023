<?php

namespace Dimal\Hw11\Presentation;

use Dimal\Hw11\Application\TableViewInterface;
use Dimal\Hw11\Domain\Entity\Book;
use Dimal\Hw11\Domain\Repository\BookRepositoryInterface;

class ConsoleTableView implements TableViewInterface
{
    private array $cols = [];
    private array $rows = [];

    public function __construct()
    {
        $this->cols = [
            'category' => ['title' => 'Категория', 'width' => 20],
            'title' => ['title' => 'Наименование', 'width' => 50],
            'id' => ['title' => 'sku', 'width' => 10],
            'price' => ['title' => 'Цена', 'width' => 10],
            'avail' => ['title' => 'Наличие', 'width' => 25]
        ];
    }


    private function setRows($rows): void
    {
        $this->rows = $rows;
    }

    public function show(BookRepositoryInterface $booksRepository): void
    {

        $rows = [];
        $books = $booksRepository->getAll();
        foreach ($books as $book) {
            /** @var Book $book */

            $availStr = '';
            foreach ($book->getStockCount() as $stockShopCount) {
                /** @var StockShopCount $stockShopCount */
                $availStr .= $stockShopCount->getShop()->getName() . ': ' . $stockShopCount->getStockCount()->getCount() . ', ';
            }
            $availStr = substr($availStr, 0, -2);

            $row = [
                'category' => $book->getCategory()->getName(),
                'title' => $book->getTitle()->getTitle(),
                'id' => $book->getId()->getId(),
                'price' => $book->getPrice()->getFormattedPrice(),
                'avail' => $availStr
            ];

            array_push($rows, $row);
        }


        $this->setRows($rows);
        $this->showTableHeader();
        $this->showTableBody();
        $this->showTableFooter();
    }

    private function showTableHeader(): void
    {
        echo PHP_EOL;
        foreach ($this->cols as $c) {
            echo "+" . str_repeat('-', $c['width']);
        }
        echo "+" . PHP_EOL;

        foreach ($this->cols as $c) {
            echo "| " . self::mbStrPad($c['title'], $c['width'] - 1);
        }
        echo "|" . PHP_EOL;

        foreach ($this->cols as $c) {
            echo "+" . str_repeat('-', $c['width']);
        }
        echo "+" . PHP_EOL;
    }

    private function showTableBody(): void
    {
        foreach ($this->rows as $row) {
            foreach ($this->cols as $col_name => $col) {
                echo "| " . self::mbStrPad($row[$col_name], $col['width'] - 1);
            }

            echo "|" . PHP_EOL;
        }
    }

    private function showTableFooter(): void
    {
        foreach ($this->cols as $c) {
            echo "+" . str_repeat('-', $c['width']);
        }
        echo "+" . PHP_EOL;
    }


    private static function mbStrPad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = 'UTF-8'): string
    {
        $input_length = mb_strlen($input, $encoding);
        $pad_string_length = mb_strlen($pad_string, $encoding);


        if ($input_length > $pad_length) {
            $result = mb_substr($input, 0, $pad_length, $encoding);
            return $result;
        }

        if ($pad_length <= 0 || ($pad_length - $input_length) <= 0) {
            //return $input;
        }

        $num_pad_chars = $pad_length - $input_length;

        switch ($pad_type) {
            case STR_PAD_RIGHT:
                $left_pad = 0;
                $right_pad = $num_pad_chars;
                break;

            case STR_PAD_LEFT:
                $left_pad = $num_pad_chars;
                $right_pad = 0;
                break;

            case STR_PAD_BOTH:
                $left_pad = floor($num_pad_chars / 2);
                $right_pad = $num_pad_chars - $left_pad;
                break;
        }

        $result = '';
        for ($i = 0; $i < $left_pad; ++$i) {
            $result .= mb_substr($pad_string, $i % $pad_string_length, 1, $encoding);
        }
        $result .= $input;
        for ($i = 0; $i < $right_pad; ++$i) {
            $result .= mb_substr($pad_string, $i % $pad_string_length, 1, $encoding);
        }


        return $result;
    }
}
