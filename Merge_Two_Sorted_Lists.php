<?php

class Solution {

    function quickSort(&$arr, $left, $right) {
        if ($left < $right) {
            // Разбиение массива и получение индекса опорного элемента
            $pivotIndex = $this->partition($arr, $left, $right);

            // Рекурсивно сортируем подмассивы слева и справа от опорного элемента
            $this->quickSort($arr, $left, $pivotIndex - 1);
            $this->quickSort($arr, $pivotIndex + 1, $right);
        }
    }

    function partition(&$arr, $left, $right) {
        // Используем последний элемент в качестве опорного
        $pivot = $arr[$right];

        // Индекс элемента, который меньше опорного
        $low = $left - 1;

        for ($i = $left; $i < $right; $i++) {
            // Если текущий элемент меньше или равен опорному, меняем его местами с элементом, меньшим опорного
            if ($arr[$i] <= $pivot) {
                $low++;
                $this->swap($arr, $low, $i);
            }
        }

        // Помещаем опорный элемент в позицию, где он должен находиться после разбиения
        $this->swap($arr, $low + 1, $right);

        // Возвращаем индекс опорного элемента
        return $low + 1;
    }

    function swap(&$arr, $i, $j) {
        $temp = $arr[$i];
        $arr[$i] = $arr[$j];
        $arr[$j] = $temp;
    }

}

$list1 = [1,2,4];
$list2 = [1,3,4];

$mergedList = array_merge($list1, $list2);
$length = count($mergedList);

print_r($mergedList);
$solution = new Solution();
$solution->quickSort($mergedList, 0, $length - 1);
print_r($mergedList);