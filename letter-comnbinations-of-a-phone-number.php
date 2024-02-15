<?php
class Solution
{

    public $mapping = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r', 's'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z'],
    ];
    function letterCombinations(string $digits): array
    {
        if ($digits == '') {
            return [];
        }

        $result = [''];

        for ($i = 0; $i < strlen($digits); $i++) {
            $temp = [];

            for ($j = 0; $j < count($result); $j++) {
                foreach ($this->mapping[$digits[$i]] as $char) {
                    $temp[] = $result[$j] . $char;
                }
            }

            $result = $temp;
        }

        return $result;
    }
}