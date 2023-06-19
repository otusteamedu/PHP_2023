<?php

class Solution
{

    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    function leftRightDifference($nums)
    {
        $n = count($nums);

        // Calculate leftSum and rightSum
        for ($i = 1; $i < $n; $i++) {
            $leftSum[$i] = $leftSum[$i - 1] + $nums[$i - 1];
            $rightSum[$n - $i - 1] = $rightSum[$n - $i] + $nums[$n - $i];
        }

        // Calculate answer
        for ($i = 0; $i < $n; $i++) {
            $answer[$i] = abs($leftSum[$i] - $rightSum[$i]);
        }
        return $answer;
    }
}
