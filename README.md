# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

- Linked List Cycle

```php
    function hasCycle($head) {
        $cursor1 = $head;
        $cursor2 = $head;
        while ($cursor1 !== null && $cursor2->next !== null) {
            $cursor1 = $cursor1->next;
            $cursor2 = $cursor2->next->next;
            if ($cursor1 === $cursor2) return true;
        }
        return false;
    }
```

- Letter Combinations of a Phone Number

```php
class Solution {
     private $letters = [
        2 => ['a', 'b', 'c'],
        3 => ['d', 'e', 'f'],
        4 => ['g', 'h', 'i'],
        5 => ['j', 'k', 'l'],
        6 => ['m', 'n', 'o'],
        7 => ['p', 'q', 'r', 's'],
        8 => ['t', 'u', 'v'],
        9 => ['w', 'x', 'y', 'z']
    ];

    function letterCombinations($digits)
    {
        if (!strlen($digits)) {
            return [];
        }
        $digitsArray = str_split($digits);
        $out = [];

        foreach ($digitsArray as $item) {
            $temp = [];
            foreach ($this->letters[$item] as $letter) {
                if (!count($out)) {
                    $temp[] = $letter;
                }
                foreach ($out as $o) {
                    $temp[] = $o . $letter;
                }
            }
            $out = $temp;
        }
        return $out;
    }
}
```
