<?php


function leftRightDifference($nums)
{
    
    $result = [];
    for($i = 0; $i < count($nums); $i++) {
        $rightSum = 0;
        $leftSum = 0;
        for($j = $i + 1; $j < count($nums); $j++) {
            $rightSum += $nums[$j];
        }
        for($j = 0; $j < $i; $j++ ) {
            $leftSum += $nums[$j];
        }

        $result[] = abs($leftSum - $rightSum);
    }
    return $result;

}

print_r( leftRightDifference([10, 4, 8, 3]));
