<?php

/**
 * task https://leetcode.com/problems/left-and-right-sum-differences/
 * @param array $nums
 * @return array
 */
function leftRightDifference(array $nums): array
{
    $cnt = count($nums);
    if ($cnt <= 0) {
        return [];
    }
    $out = array_fill(0, $cnt, 1);
    $left = $out;
    $right = $out;
    for ($i = 0; $i < $cnt; $i++) {
        $e = $cnt - $i - 1;
        if ($i === 0) {
            $left[$i] = 0;
            $right[$e] = 0;
        } else {
            $left[$i] = $left[$i - 1] + $nums[$i - 1];
            $right[$e] = $right[$e + 1] + $nums[$e + 1];
        }
        $out[$i] = abs($right[$i] - $left[$i]);
        $out[$e] = abs($right[$e] - $left[$e]);
    }
    return $out;
}


$arr = [10, 4, 8, 3];
$outEtalon = [15, 1, 11, 22];
$res = leftRightDifference($arr);

echo '<pre>' . print_r([$arr, $res], 1) . '</pre>';
