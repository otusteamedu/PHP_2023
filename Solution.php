<?php

declare(strict_types=1);

class Solution
{
    /**
     * Решение задачи: https://leetcode.com/problems/find-the-pivot-integer/
     * 
     * @param int $n
     * @return int
     */
    function pivotInteger(int $n): int
    {
        if ($n == 1) {
            return 1;
        }

        if ($n == 2) {
            return -1;
        }

        for ($i = 2; $i < $n; $i++) {
            $firstSum = 0;
            for ($j = 1; $j <= $i; $j++) {
                $firstSum += $j;
            }

            $secondSum = 0;
            for ($j = $i; $j <= $n; $j++) {
                $secondSum += $j;
            }

            if ($firstSum == $secondSum) {
                return $i;
            }
        }

        return -1;
    }
}