<?php


function leftRightDifference($nums)
{
    $arrayLength = count($nums);

    if($arrayLength > 1000) {
        return throw  new \Exception('Not available array quantity');
    }

    if($arrayLength > 0) {
        $result = [];
        for($i = 0; $i < $arrayLength; $i++) {
           
            if($nums[$i] > 100_000 || $nums[$i] < 0) {
               return throw new Exception('Provided number is greater than limit [0 - 100.000]');
            }
            
            $rightSum = 0;
            $leftSum = 0;
            for($j = $i + 1; $j < $arrayLength; $j++) {
                $rightSum += $nums[$j];
            }
            for($j = 0; $j < $i; $j++ ) {
                $leftSum += $nums[$j];
            }
    
            $result[] = abs($leftSum - $rightSum);
        }
        return $result;
    }
    
}

print_r( leftRightDifference([100_001, 4, 8, 3]));
