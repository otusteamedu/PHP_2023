<?php

declare(strict_types=1);

namespace Solution;

class Solution {
    /**
     * @param Integer $n
     * @return Integer
     */
    public function pivotInteger($n): int
    {
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

    private function getFullSum ($n): int
    {
        $result = 0;
        for ($i = 1; $i <= $n; $i++) {
            $result += $i;
        }
        return $result;
    }
}
