<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Yalanskiy\LeetCode\LetterCombinations\Solution;

try {
    $digits = '259';
    $combinations = Solution::letterCombinations($digits);
    print_r($combinations);
} catch (Exception $ex) {
    echo $ex->getMessage();
}
