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
        if (empty($digits)) {
            return [];
        }

        $buttons = [
            2 => ['a', 'b', 'c'],
            3 => ['d', 'e', 'f'],
            4 => ['g', 'h', 'i'],
            5 => ['j', 'k', 'l'],
            6 => ['m', 'n', 'o'],
            7 => ['p', 'q', 'r', 's'],
            8 => ['t', 'u', 'v'],
            9 => ['w', 'x', 'y', 'z'],
        ];

        $output = [''];

        for ($i = 0; $i < strlen($digits); $i++) {
            $_output = [];

            for ($j = 0; $j < count($output); $j++) {
                foreach ($buttons[$digits[$i]] as $letter) {
                    $_output[] = $output[$j] . $letter;
                }
            }

            $output = $_output;
        }

        return $output;
    }
}
