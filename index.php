<?php

class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    function productExceptSelf(array $nums): array
    {
        $length = count($nums);
        $resultArray = array_fill(0, $length, 1);
        $acc1 = $acc2 = 1;
        for ($i = 0, $j = $length - 1; $i < $length; $i++, $j--) {
            $resultArray[$i] *= $acc1;
            $acc1 *= $nums[$i];

            $resultArray[$j] *= $acc2;
            $acc2 *= $nums[$j];
        }
        return $resultArray;
    }
}
