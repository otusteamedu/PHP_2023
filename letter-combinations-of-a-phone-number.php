<?php

declare(strict_types=1);

class Solution
{
    function letterCombinations(string $digits): array
    {
        if (strlen($digits) == 0) {
            return [];
        }

        $map = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $result = [''];

        for ($i = 0; $i < strlen($digits); $i++) {
            $new_result = [];

            for ($j = 0; $j < count($result); $j++) {
                foreach ($map[$digits[$i]] as $char) {
                    $new_result[] = $result[$j] . $char;
                }
            }

            $result = $new_result;
        }

        return $result;
    }
}

$solution = new Solution();

var_dump($solution->letterCombinations('23'));
