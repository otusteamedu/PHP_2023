<?php

namespace RYuzyuk\Hw14;

class Solution
{
    private array $buttons = [
        "2" => ['a', 'b', 'c'],
        "3" => ['d', 'e', 'f'],
        "4" => ['g', 'h', 'i'],
        "5" => ['j', 'k', 'l'],
        "6" => ['m', 'n', 'o'],
        "7" => ['p', 'q', 'r', 's'],
        "8" => ['t', 'u', 'v'],
        "9" => ['w', 'x', 'y', 'z']
    ];
    private array $result = [];

    /**
     * @param String $digits
     * @return String[]
     * Сложность O(1)
     */
    public function letterCombinations(string $digits): array
    {
        if (!strlen($digits)) {
            return $this->result;
        }

        return $this->generateCombinations($digits);
    }

    private function generateCombinations(string $digits, string $combine = '', int $index = 0): array
    {
        foreach ($this->buttons[$digits[$index]] as $currentButton) {
            if ($this->buttons[$digits[$index + 1]]) {
                $this->generateCombinations($digits, $combine . $currentButton, $index + 1);
            } else {
                $this->result[] = $combine . $currentButton;
            }
        }

        return $this->result;
    }
}
