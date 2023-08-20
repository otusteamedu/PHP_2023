<?php

declare(strict_types=1);

namespace App\Solution;

class Solution
{
    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        if (!strlen($digits)) {
            return [];
        }

        $slices = [
            2 => ['a', 'b', 'c'],
            3 => ['d', 'e', 'f'],
            4 => ['g', 'h', 'i'],
            5 => ['j', 'k', 'l'],
            6 => ['m', 'n', 'o'],
            7 => ['p', 'q', 'r', 's'],
            8 => ['t', 'u', 'v'],
            9 => ['w', 'x', 'y', 'z']
        ];

        $res = [];
        return $this->recursion(0, $digits, $slices, $res);
    }

    private function recursion(int $index, string $digits, array $slices, array &$res, string $accum = ''): array
    {
        foreach ($slices[$digits[$index]] as $slice) {
            if (isset($digits[$index + 1])) {
                $this->recursion($index + 1, $digits, $slices, $res, $accum . $slice[0]);
            } else {
                $res[] = $accum . $slice[0];
            }
        }
        return $res;
    }
}

$solution = new Solution();
print_r($solution->letterCombinations('234'));
