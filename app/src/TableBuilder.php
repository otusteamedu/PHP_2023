<?php

declare(strict_types=1);

namespace Root\App;

class TableBuilder
{
    const SPACE_LINE = '-';
    const SPACE_SPACE = ' ';
    const DELIMITER_LINE = '|';
    const DELIMITER_CROSS = '+';
    const PADDING = 1;

    public array $columnCallbacks = [];
    private array $columnsTitle = [];
    private array $columnAssign = [];
    /**
     * @var TableRowDto[] $data
     */
    private array $data = [];

    private array $width = [];

    public function setTitle(array $title): TableBuilder
    {
        $keys = array_keys($title);
        $isAssign = false;
        foreach ($keys as $key) {
            $isAssign = is_string($key);
            if (!$isAssign) {
                break;
            }
        }
        if ($isAssign) {
            $this->columnAssign = $keys;
        }

        $this->columnsTitle = array_values($title);

        return $this;
    }

    public function setAssign(array $assign): TableBuilder
    {
        $this->columnAssign = $assign;
        return $this;
    }

    public function setData(array $data): TableBuilder
    {
        $this->data = $data;
        return $this;
    }

    public function setColumnCallback(int $column, $callback): TableBuilder
    {
        if (is_callable($callback)) {
            $this->columnCallbacks[$column] = $callback;
        }
        return $this;
    }
    public function toString(): string
    {
        $table = '';

        $this->calcWidth();

        $table .= $this->buildRow(true, [], true);
        $table .= $this->buildRow(
            false,
            $this->columnsTitle,
            true
        );
        $table .= $this->buildRow(true, [], true);

        if (!empty($this->data)) {
            foreach ($this->data as $row) {
                $values_array = [];
                foreach ($this->columnAssign as $index => $key) {
                    $values_array[$index] = property_exists($row, $key) ? $row->{$key} : '';
                }
                $table .= $this->buildMultiLineRow(
                    false,
                    $values_array
                );
            }
        }
        $table .= $this->buildRow(true, [], true);

        return $table;
    }

    private function calcWidth(): void
    {
        foreach ($this->columnsTitle as $str) {
            $this->width[] = mb_strlen($str);
        }

        if (!empty($this->data)) {
            foreach ($this->data as $row) {
                foreach ($this->columnAssign as $num => $assign) {
                    if (!isset($this->width[$num])) {
                        $this->width[$num] = 0;
                    }
                    $value = property_exists($row, $assign) ? $row->{$assign} : '';
                    if (isset($this->columnCallbacks[$num])) {
                        $value = $this->columnCallbacks[$num]($value);
                    }
                    if (is_array($value)) {
                        foreach ($value as $subRow) {
                            $this->width[$num] = max($this->width[$num], mb_strlen("{$subRow}"));
                        }
                    } else {
                        $this->width[$num] = max($this->width[$num], mb_strlen("{$value}"));
                    }
                }
            }
        }
    }

    private function buildRow(bool $line = false, array $values = [], $title = false): string
    {
        $space = $line ? self::SPACE_LINE : self::SPACE_SPACE;
        $delim = $line ? self::DELIMITER_CROSS : self::DELIMITER_LINE;
        $index = 0;

        $str = $delim;
        foreach ($this->width as $value) {
            $strText = str_repeat($space, self::PADDING);
            if (isset($values[$index])) {
                if (!$title && isset($this->columnCallbacks[$index])) {
                    $strText .= $this->columnCallbacks[$index]($values[$index]);
                } else {
                    $strText .= $values[$index];
                }
            }
            $str .= $strText . str_repeat($space, $value + self::PADDING + self::PADDING - mb_strlen($strText));
            $str .= $delim;
            $index++;
        }

        $str .= PHP_EOL;
        return $str;
    }

    private function buildMultiLineRow(bool $line = false, array $values = []): string
    {
        $lines = [];
        $linesData = [];

        foreach ($values as $index => $value) {
            if (is_array($value)) {
                if (!empty($value)) {
                    if (isset($this->columnCallbacks[$index])) {
                        $array = $this->columnCallbacks[$index]($value);
                    } else {
                        $array = $value;
                    }
                    foreach ($array as $rowIndex => $subValue) {
                        $linesData[0 + $rowIndex][$index] = $subValue;
                    }
                }
            } else {
                $linesData[0][$index] = $value;
            }
        }

        foreach ($linesData as $data) {
            $lines[] = $this->buildRow($line, $data);
        }

        return implode('', $lines);

    }
}
