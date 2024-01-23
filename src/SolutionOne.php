<?php

namespace HW11\Elastic;

/**
 * временная сложность O(n × m)
 * название файла изменил чтобы не было повторов, а сам класс оставил чтобы при проверке на литкоде не возникало ошибок
 */

class Solution
{
    public function letterCombinations(string $digits): array
    {
        $output = [];
        if (!$digits) {
            return $output;
        }
        return $this->getLettersCombinations((string)$digits);
    }
    public function getLettersCombinations(string $digits = '', string $initialSet = null): array
    {
        $mapping = [
            2 => 'abc',
            3 => 'def',
            4 => 'ghi',
            5 => 'jkl',
            6 => 'mno',
            7 => 'pqrs',
            8 => 'tuv',
            9 => 'wxyz',
        ];
        if ($digits === '') {
            $lettersCombinations = [];
            for ($i = 0, $iMax = strlen($initialSet); $i < $iMax; $i++) {
                $lettersCombinations[] = $initialSet[$i];
            }
            return $lettersCombinations;
        }
        $set       = $mapping[$digits[0]];
        $cutDigits = substr($digits, 1);
        $lettersCombinations = $this->getLettersCombinations($cutDigits, $set);
        if ($initialSet) {
            $combinations = [];
            for ($i = 0, $iMax = count($lettersCombinations); $i < $iMax; $i++) {
                for ($j = 0, $jMax = strlen($initialSet); $j < $jMax; $j++) {
                    $combinations[] = $initialSet[$j] . $lettersCombinations[$i];
                }
            }
            $lettersCombinations = $combinations;
        }
        return $lettersCombinations;
    }
}
