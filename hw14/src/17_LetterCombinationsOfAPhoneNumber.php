<?php

namespace src;

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
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

            for ($i = 0; $i < strlen($initialSet); $i++) {
                $lettersCombinations[] = $initialSet[$i];
            }

            return $lettersCombinations;
        }

        $set = $mapping[$digits[0]];
        $cutDigits = substr($digits, 1);

        $lettersCombinations = $this->getLettersCombinations($cutDigits, $set);

        if ($initialSet) {
            $combinations = [];
            for ($i = 0; $i < count($lettersCombinations); $i++) {
                for ($j = 0; $j < strlen($initialSet); $j++) {
                    $combinations[] = $initialSet[$j] . $lettersCombinations[$i];
                }
            }
            $lettersCombinations = $combinations;
        }

        return $lettersCombinations;
    }
}
