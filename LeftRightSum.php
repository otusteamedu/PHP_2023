<?php

namespace App;

class LeftRightSum
{
    /**
     * Сложность алгоритма O(n).
     */
    public function leftRightDifference(array $nums): array
    {
        $arrayLeft = [];
        $arrayRight = [];
        $arrayLength = count($nums);
        $array = [];

        for ($i = 0; $i < $arrayLength; $i++) {
            $leftSum = 0;
            $rightSum = 0;

            for ($b = 0; $b < $i; $b++) {
                $leftSum += $nums[$b];
            }
            $arrayLeft[] = $leftSum;

            for ($c = $i + 1; $c < $arrayLength; $c++) {
                $rightSum += $nums[$c];
            }

            $arrayRight[] = $rightSum;
        }

        foreach (array_combine($arrayRight, $arrayLeft) as $right => $left) {
            $array[] = abs($left - $right);
        }

        return $array;
    }
}

$nums = [10,4,8,3];
$solution = new LeftRightSum();
$solution->leftRightDifference($nums);
