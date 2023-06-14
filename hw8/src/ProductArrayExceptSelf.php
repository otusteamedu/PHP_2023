<?php

namespace ProductArrayExceptSelf;

/**
 * Given an integer array 'nums', return an array 'answer' such that
 * answer[i] is equal to the product of all the elements of 'nums' except nums[i].
 *
 * The product of any prefix or suffix of 'nums' is guaranteed to fit in a 32-bit integer.
 * You must write an algorithm that runs in O(n) time and without using the division operation.
 *
 * Example 1:
 * Input:   nums = [1,2,3,4]
 * Output:  [24,12,8,6]
 *
 * Example 2:
 * Input:   nums = [-1,1,0,-3,3]
 * Output:  [0,0,9,0,0]
 *
 * Constraints:
 * 2 <= nums.length <= 105
 * -30 <= nums[i] <= 30
 * The product of any prefix or suffix of 'nums' is guaranteed to fit in a 32-bit integer.
 *
 *
 *
 * The complexity of the solution is O(n) so as the array is walked through exactly three times
 * (so, actually, the complexity is O(3n), but it is not an acceptable notation).
 */
class Solution
{
    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    public function productExceptSelf($nums)
    {
        $prefix = [];
        for ($i = 0; $i < count($nums) - 1; $i++) {
            if ($i == 0) {
                $prefix[$i + 1] = $nums[$i];
            } else {
                $prefix[$i + 1] = $prefix[$i] * $nums[$i];
            }
        }

        $suffix = [];
        for ($i = count($nums) - 1; $i >= 0; $i--) {
            if ($i == count($nums) - 1) {
                $suffix[$i - 1] = $nums[$i];
            } else {
                $suffix[$i - 1] = $suffix[$i] * $nums[$i];
            }
        }

        $answer = [];
        for ($i = 0; $i < count($nums); $i++) {
            if (isset($prefix[$i]) && isset($suffix[$i])) {
                $answer[$i] = $prefix[$i] * $suffix[$i];
            } elseif (isset($prefix[$i])) {
                $answer[$i] = $prefix[$i];
            } elseif (isset($suffix[$i])) {
                $answer[$i] = $suffix[$i];
            }
        }

        return $answer;
    }
}
