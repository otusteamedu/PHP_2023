<?php
class Solution {

    /**
     * @param Integer $n
     * @return Integer
     * O(n)
     * S(n)
     */
    function pivotInteger($n) {
        $sum = $n * (1+$n)/2;
        $leftSum =0;
        if($n == 1) return 1;
        for($i=1; $i <= $n; $i++) {
            $sum-=$i;
            $leftSum += $i;
            if($sum === $leftSum + $i +1 ){
                return $i + 1;
            }
        }
        return -1;
    }
}