<?php

namespace Dimal\Hw11\Presentation;

class ConsoleTableView
{
    private array $cols = [];
    private array $rows = [];

    public function setCols($cols): void
    {
        $this->cols = $cols;
    }

    public function setRows($rows): void
    {
        $this->rows = $rows;
    }

    public function showTable(): void
    {
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
            echo "| " . self::mb_str_pad($c['title'], $c['width'] - 1);
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
                echo "| " . self::mb_str_pad($row[$col_name], $col['width'] - 1,);
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


    public static function mb_str_pad($input, $pad_length, $pad_string = ' ', $pad_type = STR_PAD_RIGHT, $encoding = 'UTF-8'): string
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