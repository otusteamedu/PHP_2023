<?php

declare(strict_types=1);

namespace Chernomordov\App;

class Solution
{
    /**
     * @param Integer[] $nums
     * @return Integer
     */
    public function removeDuplicates(&$nums)
    {
        $count = count($nums);
        $writeIndex = 1;

        for ($i = 1; $i < $count; $i++) {
            if ($nums[$i] !== $nums[$i - 1]) {
                $nums[$writeIndex] = $nums[$i];
                $writeIndex++;
            }
        }

        return $writeIndex;
    }

    /**
     * @param Integer[] $nums
     * @return Integer
     */
    public function missingNumber($nums)
    {
        $len = count($nums);
        $oriLen = $len + 1;
        $oriSum = ($oriLen - 1) * $oriLen / 2;

        $curSum = 0;
        foreach ($nums as $n) {
            $curSum += $n;
        }

        return $oriSum - $curSum;
    }

    public function lengthOfLongestSubstring($s)
    {
        $start = 0;
        $length = 0;
        for ($i = 0; $i < strlen($s); $i++) {
            $char = $s[$i];
            if (isset($arr[$char]) && $arr[$char] >= $start) {
                $start = $arr[$char] + 1;
            } elseif ($i - $start === $length) {
                $length++;
            }
            $arr[$char] = $i;
        }
        return $length;
    }
}
