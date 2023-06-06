<?php

declare(strict_types=1);

/**
 * Решение задачи https://leetcode.com/problems/product-of-array-except-self/
 *
 * Первый проход делаем - ищем произведение ненулевых элементов и считаем количество нулевых элементов
 * Второй проход - формируем результат
 *
 * Могут быть ситуации:
 * * Нулей нет, тогда просто делим на текущий элемент
 * * один ноль: тогда у нас все, кроме текущего нулевого элемента, будут нули
 * * два и более нулей - весь реузьтат будет забит нулями
 */
class Solution
{
    /**
     * @param Integer[] $nums
     * @return Integer[]
     */
    function productExceptSelf($nums)
    {
        $result = [];

        $countZero = 0;
        $productFirst = 0;

        foreach ($nums as $num) {
            if ($num === 0) {
                $countZero++;
            } else {
                if ($productFirst === 0) {
                    $productFirst = $num;
                } else {
                    $productFirst *= $num;
                }
            }
        }

        foreach ($nums as $num) {
            $product = 0;
            if (
                $countZero === 1
                && $num === 0
            ) {
                $product = $productFirst;
            }

            if ($countZero === 0) {
                $product = $productFirst / $num;
            }

            $result[] = $product;
        }

        return $result;
    }
}

$solution = new Solution();

$nums = [1,2,3,4];
$rows = [
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
    echo 'Output:' . implode(',', $solution->productExceptSelf($nums)) . PHP_EOL;
    echo '============================' . PHP_EOL;
}
