<?php
class Solution {

    /**
     * @param Integer[] $nums
     * @return Integer[]
     * O(n)
     * S(n)
     */

    function leftRightDifference($nums) {
        $leftSum = [];
        $rightSum = [];
        $answer = [];
        $len = count($nums);
        for($i=0; $i<$len; $i++){
            array_push($leftSum, $nums[$i] + $leftSum[$i-1]);
        }
        for($i=$len-1; $i>0; $i--){
            array_push($rightSum,$nums[$i] + $rightSum[$len-$i-2]);
        }
        array_push($rightSum, 0);
        $reversed = array_reverse($rightSum);
        $leftSum[$len-1] = 0;
        for($i=0; $i<count($nums); $i++){
            array_push($answer, abs($leftSum[$i-1] - $rightSum[$len-$i-2]));
        }
        return $answer;
    }
}