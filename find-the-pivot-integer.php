<?php

/**
 * task https://leetcode.com/problems/find-the-pivot-integer/
 * @param $n
 * @return int
 */
function pivotInteger(int $n): int
{
    if ($n < 1) {
        return -1;
    }
    $left = array_fill(1, $n, 0);
    $right = $left;
    for ($i = 1; $i <= $n; $i++) {
        $e = $n - $i + 1;
        if ($i === 1) {
            $left[$i] = $i;
            $right[$e] = $e;
        } else {
            $left[$i] = $left[$i - 1] + $i;
            $right[$e] = $right[$e + 1] + $e;
        }

        if ($left[$i] === $right[$i]) {
            return $i;
        }
    }
    return -1;
}


for ($i = 4; $i <= 100; $i++) {
    $res = pivotInteger($i);
    echo '<pre>' . print_r([$i, $res], 1) . '</pre>';
}
