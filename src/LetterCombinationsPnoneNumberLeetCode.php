<?php

declare(strict_types=1);

namespace Art\Php2023;

class Solution
{
    private $results;

    private $phoneData = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z'],
    ];

    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        if (strlen($digits) === 0) {
            return [];
        }
        $this->search($digits);

        return $this->results;
    }

    protected function search($digits, $pos = 0, $prefix = ""): void
    {
        $digit = (int)$digits[$pos];
        foreach ($this->phoneData[$digit] as $char) {
            if ($pos < strlen($digits) - 1) {
                $this->search($digits, $pos + 1, $prefix . $char);
            } else {
                $this->results[] = $prefix . $char;
            }
        }
    }
}
