<?php

/** https://leetcode.com/problems/letter-combinations-of-a-phone-number/ */

namespace App;

class Solution2
{
    /** @var string[]  */
    const MAP = [
        '2' => "abc",
        '3' => "def",
        '4' => "ghi",
        '5' => "jkl",
        '6' => "mno",
        '7' => "pqrs",
        '8' => "tuv",
        '9' => "wxyz"
    ];

    /**
     * @param string $digits
     * @return string[]
     */
    public function letterCombinations(string $digits): array
    {
        if ($digits == '') {
            return [];
        }

        $symbols = array_map(function ($item) {
            return self::MAP[$item];
        }, str_split($digits));

        $result = [];

        for ($i = 0; $i < count($symbols); $i++) {
            if (empty($result)) {
                foreach (str_split($symbols[$i]) as $symbol) {
                    $result[] = $symbol;
                }
            } else {
                $tmp = [];

                foreach ($result as $item) {
                    foreach (str_split($symbols[$i]) as $symbol) {
                        $tmp[] = $item . $symbol;
                    }
                }

                $result = $tmp;
            }
        }

        return $result;
    }
}
