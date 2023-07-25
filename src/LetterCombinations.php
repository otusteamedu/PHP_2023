<?php

declare(strict_types=1);

final class Solution {

    /**
     * Сложность линейная O(n), поскольку мы по сути просто перемножаем a и b
     *
     * @param numeric-string $digits
     * @return string[]
     */
    public function letterCombinations(string $digits): array
    {
        $mapping = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $digitsLength = strlen($digits);
        $result = [];
        for ($i = 0; $i < $digitsLength; $i++) {
            $chars = $mapping[$digits[$i]];

            if ($i === 0) {
                $result = $chars;
                continue;
            }

            $charsLength = count($chars);
            $resultLength = count($result);

            $newResult = [];

            for ($j = 0; $j < $resultLength; $j++) {
                for ($k = 0; $k < $charsLength; $k++) {
                    $newResult[] = $result[$j] . $chars[$k];
                }
            }

            $result = $newResult;
        }

        return $result;
    }
}

$result = (new Solution())->letterCombinations('22');
var_dump($result);

