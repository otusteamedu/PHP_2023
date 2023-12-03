# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Задание

## Цель
https://leetcode.com/problems/intersection-of-two-linked-lists/
https://leetcode.com/problems/fraction-to-recurring-decimal/

## Описание/Пошаговая инструкция выполнения домашнего задания:
- Решаем задачу
- Прикладываем код на GitHub
- Обосновываем сложность

## Критерии оценки
- Решение имеет оптимальную сложность
- Учтены исключительные случаи
- Решение проходит тесты

# Решение

## Задача 1

https://leetcode.com/problems/intersection-of-two-linked-lists/

```php
class Solution {
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB) {
        $hash = [];

        while ($headA) {
            $hash[spl_object_id($headA)] = true;
            $headA = $headA->next;
        }

        while ($headB) {
            if (array_key_exists(spl_object_id($headB), $hash)) {
                return $headB;
            }

            $headB = $headB->next;
        }

        return null;
    }
}
```

Сложность: O(n)

## Задача 2

https://leetcode.com/problems/fraction-to-recurring-decimal/

```php
class Solution {
   public static function fractionToDecimal($numerator, $denominator) {
        if ($numerator === 0) {
            return '0';
        }

        if (($numerator < 0 && $denominator > 0) || ($numerator > 0 && $denominator < 0)) {
            $prefix = '-';
        } else {
            $prefix = '';
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $result = $numerator / $denominator;
        $leftPart = floor($result);
        $rightPart = $result - $leftPart;

        if ($rightPart === 0.0) {
            return $prefix . $leftPart;
        }

        $rightPart = (string) $rightPart;
        $rightPart = substr($rightPart, 2);
        $rightPart = rtrim($rightPart, '0');

        for($i = 0, $maxSize = floor($rightPart / 2); $i < $maxSize; $i++) {
            $left = substr($rightPart, 0, $i + 1);
            $right = substr($rightPart, $i + 1, $i + 1);

            if ($left === $right) {
                $rightPart = '(' . substr($rightPart, 0, $i + 1) . ')';
                break;
            }
        }

        return $prefix . $leftPart . '.' . $rightPart;
   }
}
```

Сложность: O(n)

