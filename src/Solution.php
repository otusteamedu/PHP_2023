<?php

declare(strict_types=1);

namespace Chernomordov\App;

class Solution
{
    private const VALUES = [
        'I' => 1,
        'V' => 5,
        'X' => 10,
        'L' => 50,
        'C' => 100,
        'D' => 500,
        'M' => 1000,
    ];

    private const DIGITS = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1,
    ];

    /**
     * @param string $s
     * @return int
     */
    private function romanToInt(string $s): int
    {
        $result = 0;
        $prev = 0;
        $i = 0;

        do {
            $value = self::VALUES[$s[$i]];
            $result += $value - ($value > $prev ? $prev * 2 : 0);
            $prev = $value;
            ++$i;
        } while ($s[$i]);

        return $result;
    }

    /**
     * @param int $s
     * @return string
     */
    private function intToRoman(int $s): string
    {
        $result = '';

        foreach (self::DIGITS as $out => $num) {
            $c = intdiv($s, $num);
            $s -= $c * $num;
            $result .= str_repeat($out, $c);
        }

        return $result;
    }

    /**
     * @param array $board
     * @return bool
     */
    public function isValidSudoku(array $board): bool
    {
        $rows = $columns = $boxes = [];
        $i = $j = 0;

        while (true) {
            $item = $board[$i][$j];

            if ('.' !== $item && isset($rows[$i][$item])) {
                return false;
            }

            if ('.' !== $item && isset($columns[$j][$item])) {
                return false;
            }

            $boxIndex = ceil(($i + 1) / 3) . ceil(($j + 1) / 3);

            if ('.' !== $item && isset($boxes[$boxIndex][$item])) {
                return false;
            }

            $rows[$i][$item] = $item;
            $columns[$j][$item] = $item;
            $boxes[$boxIndex][$item] = $item;

            $j++;

            if (10 === $j) {
                $j = 0;
                $i++;
            }

            if (10 === $i) {
                break;
            }
        }

        return true;
    }
}
