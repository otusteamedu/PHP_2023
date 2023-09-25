<?php

declare(strict_types=1);

//Задание
//https://leetcode.com/problems/left-and-right-sum-differences/
//Учитывая 0-индексированный целочисленный массив nums, найдите 0-индексированный целочисленный массив answer, где:
//
//answer.length == nums.length.
//answer[i] = |leftSum[i] - rightSum[i]|.
//
//Где:
//
//leftSum[i] представляет собой сумму элементов слева от индекса i в массиве nums. Если такого элемента нет, leftSum[i] = 0.
//rightSum[i] представляет собой сумму элементов справа от индекса i в массиве nums. Если такого элемента нет, rightSum[i] = 0.
//Возвращает массив answer.

$values = [
    2,
    3,
    3,
    20,
];

try {
    runHomeWork($values);
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
}


/**
 * Функция, выполняющая задание, описанное выше.
 *
 * @param $nums
 * @return array|int[]
 */
function leftRightDifference($nums): array
{
    $len = count($nums);
    if ($len === 0) {
        return [];
    }
    if ($len === 1) {
        return [0];
    }

    $leftSum = 0;
    $rightSum = 0;
    $answer = [];

    foreach ($nums as $num) {
        $rightSum += $num;
    }
    for ($i = 0; $i < $len; $i++) {
        $answer[] = abs($leftSum - ($rightSum - $nums[$i]));
        $leftSum += $nums[$i];
        $rightSum -= $nums[$i];
    }
    return $answer;
}


/**
 * Функция запускает тесты из задания. При успешном выполнении
 * запускает функцию leftRightDifference по переданным параметрам
 * и проверяет результат
 * @throws Exception
 */
function runHomeWork($values): void
{
    $test = [
        'test1' => [
            'condition' => [10, 4, 8, 3],
            'result' => [15, 1, 11, 22],
        ],
        'test2' => [
            'condition' => [1],
            'result' => [0],
        ],
    ];
    foreach ($test as $key => $value) {
        $result = leftRightDifference($value['condition']);
        if ($result === $value['result']) {
            echo $key . ' пройден успешно. ' . PHP_EOL;
        } else {
            throw new \Exception("Тест $key не пройден");
        }
    }
    echo "Тесты пройдены успешно!" . PHP_EOL;
    echo "Результат выполнения функции:" . PHP_EOL;
    print_r(leftRightDifference($values));
}
