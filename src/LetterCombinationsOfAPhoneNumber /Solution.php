<?php
declare(strict_types=1);

namespace WorkingCode\Hw14\LetterCombinationsOfAPhoneNumber;

class Solution
{
    private array $keysMap = [
        2 => 'abc',
        3 => 'def',
        4 => 'ghi',
        5 => 'jkl',
        6 => 'mno',
        7 => 'pqrs',
        8 => 'tuv',
        9 => 'wxyz',
    ];

    /**
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        return $this->charsCombinationsByPhoneKeys($digits, 0);
    }

    /**
     * @return array|string[]
     */
    private function charsCombinationsByPhoneKeys(string $phoneKeys, int $index): array
    {
        if ($phoneKeys === '') {
            return [];
        } elseif (!isset($phoneKeys[$index])) {
            return [''];
        }

        $chars = $this->keysMap[$phoneKeys[$index]];
        $index++;
        $result = [];

        for ($i = 0; $i < strlen($chars); $i++) {
            $chars2 = $this->charsCombinationsByPhoneKeys($phoneKeys, $index);

            foreach ($chars2 as $char2) {
                $result[] = $chars[$i] . $char2;
            }
        }

        return $result;
    }
}
