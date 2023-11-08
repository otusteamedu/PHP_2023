# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Задание

## Цель
https://leetcode.com/problems/linked-list-cycle/
https://leetcode.com/problems/letter-combinations-of-a-phone-number/

## Описание/Пошаговая инструкция выполнения домашнего задания
* Решаем задачу
* Прикладываем код на GitHub
* Обосновываем сложность

## Критерии оценки
* Решение имеет оптимальную сложность
* Учтены исключительные случаи
* Решение проходит тесты

# Решение

Для этой задачи я сделал 2 решения
https://leetcode.com/problems/linked-list-cycle/

```php
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        $passed = [];
        
        while ($head->next != null) {
            $id = spl_object_id($head->next);

            if (array_key_exists($id, $passed)) {
                return true;
            }

            $passed[$id] = 1;
            $head = $head->next;
        }

        return false;
    }
}
```

Сложность O(n)
Использование дополнительной памяти - O(n)

Второе решение
```php
/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution {
    /**
     * @param ListNode $head
     * @return Boolean
     */
    function hasCycle($head) {
        $prevElement = null;
        
        while ($head->next != null) {
            $id = spl_object_id($head->next);

            if ($prevElement === null) {
                $head = $head->next;
                $prevElement = $id;
                continue;
            }

            if ($id <= $prevElement) {
                return true;
            }

            $head = $head->next;
        }

        return false;
    }
}
```

Сложность O(n)
Использование дополнительной памяти - O(1)

Но оно будет работать только на тестах, при условии, что объекты ListNode будут создаваться последовательно и не удаляться. Тогда айдишки каждого объекта будет на 1 больше предыдущего и это решение сработает.

---

Решение этой задачи:
https://leetcode.com/problems/linked-list-cycle/

```php
class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        $digitsArray = str_split($digits);

        if (empty($digitsArray) || (count($digitsArray) === 1 && $digitsArray[0] === '')) {
            return [];
        }

        var_dump($digitsArray);

        $lettersMap = [
            2 => ['a', 'b', 'c'],
            3 => ['d', 'e', 'f'],
            4 => ['g', 'h', 'i'],
            5 => ['j', 'k', 'l'],
            6 => ['m', 'n', 'o'],
            7 => ['p', 'q', 'r', 's'],
            8 => ['t', 'u', 'v'],
            9 => ['w', 'x', 'y', 'z']
        ];

        $result = [];

        for($i = 0, $size = count($digitsArray); $i < $size; ++$i) {
            if (empty($result)) {
                $result = $lettersMap[$digitsArray[$i]];
                continue;
            }

            $newResult = [];

            foreach($result as $added) {
                foreach($lettersMap[$digitsArray[$i]] as $letter) {
                    $newResult[] = $added . $letter;
                }
            }

            $result = $newResult;
        }

        return $result;
    }
}
```

Сложность O(n3)
Использование дополнительной памяти - O(n)