<?php
class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer[]
     * O(n)
     * S(n)
     */
    function productExceptSelf($nums) {
        $len = count($nums);
        $leftProduct = [];
        $rightProduct = [];
        $ans = [];
        array_push($leftProduct, $nums[0]);
        array_push($rightProduct, $nums[$len-1]);
        for($i=1; $i<$len; $i++){
            array_push($leftProduct, $leftProduct[$i-1] * $nums[$i]);
            array_push($rightProduct, $rightProduct[$i-1] * $nums[$len-$i-1]);
        }
        array_unshift($leftProduct, 1);
        array_unshift($rightProduct, 1);
        for($i=1; $i<=$len; $i++){
            array_push($ans, $leftProduct[$i-1] * $rightProduct[$len-$i]);
        }
        return $ans;
    }
}