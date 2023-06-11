<?php

declare(strict_types=1);

namespace Solution;

class Solution {

    /**
     * @param Integer $n
     * @return Integer
     */
    function pivotInteger($n) {
        $left = 0;
        $right = $this->getFullSum($n);
        for ($i = 1; $i <= $n; $i++) {
                if (($left += $i) == ($right -= $i-1) 
                ) {
                return $i;
            }
        }
        return -1;
    }

    function getFullSum ($n) {
        $result = 0;
        for ($i = 1; $i <= $n; $i++) {
            $result += $i;
        }
        return $result;
    }
}
