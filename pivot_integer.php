<?php



function pivotInteger($n)
{
    $leftSum = 0;
    $rightSum = 0;

    for ($i = 1; $i <= $n; $i++) {
        $leftSum = array_sum(range(1, $i));
        $rightSum = array_sum(range($i, $n));

        if ($rightSum === $leftSum) {
            return $i;
        }
    }

    return -1;
}

echo pivotInteger(1);