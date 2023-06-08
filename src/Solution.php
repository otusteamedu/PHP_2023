<?php

declare(strict_types=1);

namespace DEsaulenko\Hw8;

/**
 * Решение задачи https://leetcode.com/problems/product-of-array-except-self/
 */
class Solution
{
    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    public function productExceptSelf(array $nums): array
    {
        $result = [];

        $length = count($nums);

        $prefix = [];
        $suffix = [];

        for ($i = 0; $i < $length; $i++) {
            $prefixElement = $i <= 0 ? 1 : $prefix[$i - 1] * $nums[$i - 1];
            $prefix[$i] = $prefixElement;

            $suffixElement = $i <= 0 ? 1 : $suffix[$i - 1] * $nums[$length - $i];
            $suffix[$i] = $suffixElement;
        }

        for ($i = 0; $i < $length; $i++) {
            $result[$i] = $prefix[$i] * $suffix[$length - $i - 1];
        }

        return $result;
    }

    public function runTests()
    {
        $rows = [
            [2,7,6,4,3],
            [2,3,4],
            [1,2,3,4], //тест из задачи
            [-1,1,0,-3,3], // тест из задачи
            [0,1,0,-3,3],
            [1,2,3,4,3,5,0],
            [7, 3],
            [0, 3],
            [3, 0],
            [0, 0],
            [12,4,6,13,2,1]
        ];

        foreach ($rows as $nums) {
            echo 'Input:' . implode(',', $nums) . PHP_EOL;
            echo 'Output:' . implode(',', $this->productExceptSelf($nums)) . PHP_EOL;
            echo '============================' . PHP_EOL;
        }
    }
}
