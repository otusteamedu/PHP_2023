### Реализация домашнего задания

* задача https://leetcode.com/problems/intersection-of-two-linked-lists/ 160. Intersection of Two Linked Lists

Реализованное решение представлено в классе `src/problem160/Solution.php`

Алгоритмическая сложность представленного решения O(n^2)

В цикле по всему списку выполняется проверка для каждого элемента первого списка
соответствие элементов в цикле по второму списку. 

Если совпадение не найдено - цикл завершит работу при соответствии крайних null-значений обоих списков.

Возвращается элемент пересечения либо null при отсутствии пересечения списков.


* задача https://leetcode.com/problems/fraction-to-recurring-decimal/ 166. Fraction to Recurring Decimal


Реализованное решение представлено в классе `src/problem166/Solution.php`

Алгоритмическая сложность представленного решения O(n)

Считается результат деления, далее результат анализируется на повторяемую последовательность как строка.
Алгоритмическая сложность прямо зависит от длины анализируемой строки.

Результат деления возвращается как строка, при наличии повторяемый период обрамлен круглыми скобками.
-- --
* установка composer-зависимостей
```shell
  composer install
```
* проверка решения раннее добавленными тестами
```shell
  php vendor/codeception/codeception/codecept run
```

Примерно такой вывод запуска тестов
```shell
Tests.Unit Tests (24) --------------------------------------------------------------------------------------------------------------
✔ Solution160Test: Example1(0.00s)
✔ Solution160Test: Example2(0.00s)
✔ Solution160Test: Example3(0.00s)
✔ Solution166Test: Example with data | #0(0.00s)
✔ Solution166Test: Example with data | #1(0.00s)
✔ Solution166Test: Example with data | #2(0.00s)
✔ Solution166Test: Example with data | #3(0.00s)
✔ Solution166Test: Example with data | #4(0.00s)
✔ Solution166Test: Example with data | #5(0.00s)
✔ Solution166Test: Example with data | #6(0.00s)
✔ Solution166Test: Example with data | #7(0.00s)
✔ Solution166Test: Example with data | #8(0.00s)
✔ Solution166Test: Example with data | #9(0.00s)
✔ Solution166Test: Example with data | #10(0.00s)
✔ Solution166Test: Example with data | #11(0.00s)
✔ Solution166Test: Example with data | #12(0.00s)
✔ Solution166Test: Example with data | #13(0.00s)
✔ Solution166Test: Example with data | #14(0.00s)
✔ Solution166Test: Example with data | #15(0.00s)
✔ Solution166Test: Example with data | #16(0.00s)
✔ Solution166Test: Example with data | #17(0.00s)
✔ Solution166Test: Example with data | #18(0.00s)
✔ Solution166Test: Example with data | #19(0.00s)
✔ Solution166Test: Example with data | #20(0.00s)
------------------------------------------------------------------------------------------------------------------------------------
Time: 00:00.033, Memory: 12.00 MB

OK (24 tests, 39 assertions)
```

-- --
