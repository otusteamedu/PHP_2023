<?php

class Solution
{
    /**
     * Given a positive integer n, find the pivot integer x such that:
     * The sum of all elements between 1 and x inclusively equals the sum of all elements between x and n inclusively.
    *  Return the pivot integer x. If no such integer exists, return -1. It is guaranteed that there will be at most one pivot index for the given input.

     * @param int $n
     * @return int
     */
    public static function pivotInteger($n)
    {
        $sum = 0;
        for ($i = 1; $i <= $n; $i++) {
            $sum += $i;
        }

        $leftSum = 0;
        for ($x = 1; $x <= $n; $x++) {
            $rightSum = $sum - $leftSum - $x;
            if ($leftSum == $rightSum) {
                return $x;
            }
            $leftSum += $x;
        }

        return -1; // No pivot found
    }

    /**
     * Given a 0-indexed integer array nums, find a 0-indexed integer array answer where:
     * answer.length == nums.length.
     * answer[i] = |leftSum[i] - rightSum[i]|.

     * Where:
     * leftSum[i] is the sum of elements to the left of the index i in the array nums. If there is no such element, leftSum[i] = 0.
     * rightSum[i] is the sum of elements to the right of the index i in the array nums. If there is no such element, rightSum[i] = 0.
     * Return the array answer.

     * @param array $nums
     * @return array
     */
    public static function leftRightDifference($nums)
    {
        $n = count($nums);
        $leftSum = array_fill(0, $n, 0);
        $rightSum = array_fill(0, $n, 0);
        $answer = array_fill(0, $n, 0);

    // Calculate leftSum and rightSum
        for ($i = 1; $i < $n; $i++) {
            $leftSum[$i] = $leftSum[$i - 1] + $nums[$i - 1];
            $rightSum[$n - $i - 1] = $rightSum[$n - $i] + $nums[$n - $i];
            print_r([$leftSum, $rightSum]);
        }

    // Calculate answer
        for ($i = 0; $i < $n; $i++) {
            $answer[$i] = abs($leftSum[$i] - $rightSum[$i]);
        }
        return $answer;
    }
}
