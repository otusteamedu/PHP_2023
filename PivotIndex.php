<?php

declare(strict_types=1);

//Доп задание https://gist.github.com/DmitryKirillov/75904cfadfee471ef0e4d1b804d9e535

$nums = [1,7,7,5,9,6,9,3,6,5,6];

function pivotIndex(array $nums): int {
    $len = count($nums);
    $copy = $nums;
    for ($i = 1; $i < $len; $i++) {
        $copy[$i] = $copy[$i - 1] + $copy[$i];
    }
    $ans = -1;

    for ($i = 0; $i < $len; $i++) {
        $indexForCheck = $i + 1;
        if ($indexForCheck === ($len - 1)) {
            return $ans;
        }

        if ($copy[$i] === ($copy[$len - 1] - $copy[$indexForCheck]))
        {
            return $i + 1;
        }
    }

    return $ans;
}

var_dump(pivotIndex($nums));