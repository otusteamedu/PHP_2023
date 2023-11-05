<?php

namespace src;

class Solution17
{
    private array $letters = [
        '2' => ['a', 'b', 'c'],
        '3' => ['d', 'e', 'f'],
        '4' => ['g', 'h', 'i'],
        '5' => ['j', 'k', 'l'],
        '6' => ['m', 'n', 'o'],
        '7' => ['p', 'q', 'r', 's'],
        '8' => ['t', 'u', 'v'],
        '9' => ['w', 'x', 'y', 'z']
    ];

    private function accStr(array $data, array $accs)
    {
        foreach ($accs as $accum) {
            foreach ($data as $item) {
                $accums[] = $accum . $item;
            }
        }

        return $accums;
    }

    /**
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        if (empty($digits)) {
            return [];
        }

        $combinations = [];
        $len = strlen($digits);
        for ($i = 0; $i < $len; $i++)
        {
            $number = $digits[$i];
            foreach ($this->letters[$number] as $letter) {
                $combinations[$number . '.' . $i][] = $letter;
            }
        }

        $tmp = [];
        $first = array_shift($combinations);
        $dt = $combinations;
        foreach ($first as $firstLetter)
        {
            $combinations = $dt;
            for ($rst = ['', '', '']; $combinations;)
            {
                $rst = $this->accStr(
                    array_shift($combinations),
                    $rst
                );
            }

            foreach ($rst as $comb) {
                $tmp[$firstLetter][] = $comb;
            }
        }

        $combs = [];
        foreach ($tmp as $key => $item) {
            foreach ($item as $subItem) {
                $combs[$key . $subItem] = $key . $subItem;
            }
        }

        return array_values($combs);
    }

}
