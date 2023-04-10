<?php

declare(strict_types=1);

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        $result = [];

        $lettersMap = [
            '2' => 'abc',
            '3' => 'def',
            '4' => 'ghi',
            '5' => 'jkl',
            '6' => 'mno',
            '7' => 'pqrs',
            '8' => 'tuv',
            '9' => 'wxyz',
        ];

        if ((strlen($digits) > 4) || (strlen($digits) < 1)) {
            return [];
        }

        $queue[] = '';

        while (count($queue) > 0) {
            $str = $queue[0];
            array_shift($queue);

            if (strlen($str) == strlen($digits)) {
                $result[] = $str;
            } else {
                $digit = $digits[strlen($str)];
                $letters = $lettersMap[$digit];

                for ($i = 0; $i < strlen($letters); $i++) {
                    $queue[] = $str . $letters[$i];
                }
            }
        }

        return $result;
    }
}
