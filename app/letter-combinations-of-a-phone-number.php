<?php

declare(strict_types=1);

require_once('vendor/autoload.php');

/**
 *
 * Сложность O(3^n * 4^m)
 * т.к. у нас комбинации букв на цифрах от 3 до 4
 */
class Solution
{

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits)
    {
        if (!$digits) {
            return [];
        }
        $letters = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $combinations = [''];
        for ($i = 0; $i < strlen($digits); $i++) {
            $tmp = [];
            foreach ($combinations as $combination) {
                foreach ($letters[$digits[$i]] as $item) {
                    $tmp[] = $combination . $item;
                }
                $combinations = $tmp;
            }
        }
        return $combinations;
    }
}

$solution = new Solution();
$r = $solution->letterCombinations('23');
dump($r);

$solution = new Solution();
$r = $solution->letterCombinations('289');
dump($r);
