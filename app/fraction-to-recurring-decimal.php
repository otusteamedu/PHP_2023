<?php

declare(strict_types=1);

namespace DEsaulenko\Hw18\Fraction;

require_once 'vendor/autoload.php';

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class Solution
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal($numerator, $denominator)
    {
        if ($denominator === 0) {
            return '';
        }

        $negative = ($numerator * $denominator) < 0 ? '-' : '';

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $left = floor($numerator / $denominator);
        $right = $this->prepareRight($numerator, $denominator);

        return $negative . $left . $right;
    }

    protected function prepareRight($numerator, $denominator)
    {
        $result = '.';

        $store = [];
        $tmp = $numerator % $denominator;
        while ($tmp !== 0) {
            $store[$tmp] = strlen($result);
            $tmp *= 10;
            $cur = floor($tmp / $denominator);
            $tmp %= $denominator;
            if (isset($store[$tmp])) {
                return substr($result, 0, $store[$tmp]) . "(" . substr($result, $store[$tmp]) . $cur . ")";
            }
            $result .= $cur;
        }

        return $result === '.' ? '' : $result;
    }
}

$numerators = [1, 2, 4, 1, 4, 6, 4, 1, -50, 1];
$denumerators = [2, 1, 333, 3, 3, 73, 11, 6, 8, 214748364];
$solution = new Solution();
foreach ($numerators as $i => $val) {
    dump([
        $val / $denumerators[$i],
        $solution->fractionToDecimal($val, $denumerators[$i])
    ]);
}
