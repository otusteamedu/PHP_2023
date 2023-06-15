<?php

declare(strict_types=1);

namespace Otus\Pivot;

class Pivot
{
    public function pivotInteger($n) {
        $array = range(1, $n);
        $length = count($array) - 1;
        $begin = 0;
        $end = $n;
        while (true) {
            $keyArray = round($length / 2);
            $purportedPivot = $array[$keyArray];
            $leftSum = array_sum(range(1, $purportedPivot));
            $rightSum = array_sum(range($purportedPivot, $n));
            if ($leftSum == $rightSum) {
                return $purportedPivot;
            }
            if ($end - $begin == 1) {
                return -1;
            }
            if ($leftSum > $rightSum)
                $end = $purportedPivot;
            else
                $begin = $purportedPivot;
            $array = range($begin, $end);
            $length = count($array) - 1;
        }
    }
}
