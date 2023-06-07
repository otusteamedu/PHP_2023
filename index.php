<?php

class Solution {

    /**
     * Алгоритм решения задачи: https://leetcode.com/problems/two-sum/ - разобрать на алгоритмах в 1 блоке
     * Сложность алгоритма: O(n)
     * @param  Integer[]  $nums
     *
     * @return Integer[]
     */
    public function leftRightDifference(array $nums): array
    {
        $ans    = [];
        $s      = 0;
        foreach ($nums as $iValue) {
            $s += $iValue;
        }

        $k = 0;
        foreach ($nums as $iValue) {
            $s      -= $iValue;
            $answer = abs($s - $k);
            $k      += $iValue;
            $ans[]  = $answer;
        }

        return $ans;
    }

    /**
     * Алгоритм решения задачи: https://leetcode.com/problems/happy-number/ (hashtable)
     * Сложность алгоритма: O(n)
     * @param Integer $n
     * @return Integer
     */
    public function pivotInteger(int $n): int
    {
        for ($i = 1; $i <= $n; $i++) {
            $leftSum = array_sum(range(1, $i));
            $rightSum = array_sum(range($i, $n));

            if ($leftSum === $rightSum) {
                return $i;
            }
        }

        return -1;
    }

    /**
     * Алгоритм решения задачи: https://leetcode.com/problems/ugly-number-ii/ (медиум, 1 массив, математика, hashtable)
     * Сложность алгоритма: O(n)
     * @param  Integer[]  $nums
     *
     * @return Integer[]
     */
    public function productExceptSelf(array $nums): array
    {
        $count = count($nums);
        $res   = [];

        $res[0] = $nums[0];
        for ($i = 1; $i < $count; $i++) {
            $res[$i] = $res[$i - 1] * $nums[$i];
        }

        for ($p = 1, $i = $count - 1; $i > 0; $i--) {
            $res[$i] = $p * $res[$i - 1];
            $p       *= $nums[$i];
        }

        $res[0] = $p;

        return $res;
    }
}

$nums = [10, 4, 8, 3];

$solution = new Solution();

print_r($solution->leftRightDifference($nums));

print_r($solution->pivotInteger(8));