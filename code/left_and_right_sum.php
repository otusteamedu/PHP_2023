<?php

declare(strict_types=1);

namespace App\Task2;
class Solution
{

    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    public function leftRightDifference($nums): array
    {
        $len = count($nums);
        $leftSum = 0;
        $totalSum = array_sum($nums);
        $answer = [];

        for ($i = 0; $i < $len; $i++) {
            $rightSum = $totalSum - $leftSum - $nums[$i];
            $answer[$i] = abs($leftSum - $rightSum);
            $leftSum += $nums[$i];
        }
        return $answer;
    }
}

$sol = new Solution();
$res = $sol->leftRightDifference(
//    [10, 4, 8, 3]
//    [-10, 14, 0, 3]
    [1]
);
echo 'Сложность: O(n)' . PHP_EOL;
echo 'Память: O(1)' . PHP_EOL;
echo 'Решение: ' . var_export($res, true) . PHP_EOL;
