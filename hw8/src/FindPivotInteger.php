<?php

namespace FindPivotInteger;

/**
 * Given a positive integer n, find the pivot integer x such that:
 *
 * The sum of all elements between 1 and x inclusively equals the sum of all elements between x and n inclusively.
 * Return the pivot integer x. If no such integer exists, return -1.
 * It is guaranteed that there will be at most one pivot index for the given input.
 *
 * Example 1:
 * Input:           n = 8
 * Output:          6
 * Explanation:     6 is the pivot integer since: 1 + 2 + 3 + 4 + 5 + 6 = 6 + 7 + 8 = 21.
 *
 * Example 2:
 * Input:           n = 1
 * Output:          1
 * Explanation:     1 is the pivot integer since: 1 = 1.
 *
 * Example 3:
 * Input:           n = 4
 * Output:          -1
 * Explanation:     It can be proved that no such integer exist.
 *
 * Constraints:
 * 1 <= n <= 1000
 *
 *
 *
 * The complexity of the solution is O(n^2) so as in the worst scenario
 * the array is walked through n times.
 */
class Solution
{
    /**
     * @param Integer $n
     * @return Integer
     */
    public function pivotInteger($n)
    {
        $sum_n_asc = 0;
        $asc_sum_array = [];
        for ($i = 1; $i <= $n; $i++) {
            $sum_n_asc += $i;
            $asc_sum_array[$i] = $sum_n_asc;
        }

        $sum_n_desc = 0;
        for ($i = $n; $i > 0; $i--) {
            $sum_n_desc += $i;

            foreach ($asc_sum_array as $index => $sum) {
                if ($sum_n_desc == $sum && $i == $index) {
                    return $index;
                }
            }
        }

        return -1;
    }
}
