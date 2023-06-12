<?php

/**
 * task https://leetcode.com/problems/product-of-array-except-self/
 * @param array $nums
 * @return array
 */
function productExceptSelf(array $nums): array
{
    $cnt = count($nums);
    if ($cnt <= 0) {
        return [];
    }
    $out = array_fill(0, $cnt, 1);
    $left = 1;
    $right = 1;
    for ($i = 0; $i < $cnt; $i++) {
        $out[$i] *= $left;
        $left *= $nums[$i];
        $out[$cnt - $i - 1] *= $right;
        $right *= $nums[$cnt - $i - 1];
    }
    return $out;
}

$arr = [1, 2, 3, 4];
$res = productExceptSelf($arr);
echo '<pre>' . print_r($res, 1) . '</pre>';
