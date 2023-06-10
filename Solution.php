<?php

declare(strict_types=1);

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

    $sum1ToN = $n * ($n + 1) / 2;
    for ($i = 2; $i < $n; $i++) {
        $firstSum = $i * ($i + 1) / 2;

        $secondSum = $sum1ToN - $firstSum + $i;

        if ($firstSum == $secondSum) {
            return $i;
        }
    }

    return -1;
}
