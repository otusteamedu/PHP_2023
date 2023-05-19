<?php

class Solution
{

    /**
     * @param String $s
     * @return int
     */
    function romanToInt($s)
    {
        $romans = [
            'I' => 1,
            'V' => 5,
            'X' => 10,
            'L' => 50,
            'C' => 100,
            'D' => 500,
            'M' => 1000,
        ];

        $result = 0;

        for ($i = 0; $i < strlen($s); $i++) {
            $current = $s[$i];
            $next = $s[$i + 1] ?? null;

            if ($next && $romans[$current] < $romans[$next]) {
                $result += $romans[$next] - $romans[$current];
                $i++;
            } else {
                $result += $romans[$current];
            }
        }

        return $result;
    }
}

var_dump((new Solution())->romanToInt('III'));
var_dump((new Solution())->romanToInt('VI'));
var_dump((new Solution())->romanToInt('MCMXCIV'));
