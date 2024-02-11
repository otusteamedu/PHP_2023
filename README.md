# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Intersection of Two Linked Lists

сложность по времени алгоритма O(n)
cложность по памяти алгоритма O(1)

```php
function getIntersectionNode($headA, $headB) {
    $lengthA = 0;
    $lengthB = 0;

    $nodeA = $headA;
    while ($nodeA->next) {
        $lengthA++;
        $nodeA = $nodeA->next;
    }
    $nodeB = $headB;
    while ($nodeB->next) {
        $lengthB++;
        $nodeB = $nodeB->next;
    }

    $nodeA = $headA;
    $nodeB = $headB;
    while ($lengthA !== $lengthB) {
        if ($lengthA > $lengthB) {
            $nodeA = $nodeA->next;
            $lengthA--;
        } else {
            $nodeB = $nodeB->next;
            $lengthB--;
        }
    }

    while ($nodeA) {
        if ($nodeA === $nodeB) {
            return $nodeA;
        }
        $nodeA = $nodeA->next;
        $nodeB = $nodeB->next;
    }

    return null;
}
```

# Fraction to Recurring Decimal

сложность по времени алгоритма O(n)
cложность по памяти алгоритма O(1)

```php

public function fractionToDecimal(int $numerator, int $denominator): string
{
    $res = '';
    if (($numerator < 0 && $denominator > 0) || ($numerator > 0 && $denominator < 0)) {
        $res = '-';
    }

    $num = abs($numerator);
    $den = abs($denominator);

    $res .= (int)($num / $den);

    $frac = $num % $den;
    if (!$frac) {
        return $res;
    }

    $res .= '.';
    $hmap = [];
    $hmap[$frac] = strlen($res);

    while ($frac !== 0) {
        $frac *= 10;
        $next = (int)($frac / $den);
        $res .= $next;
        $frac = $frac % $den;
        if (array_key_exists($frac, $hmap)) {
            return substr_replace($res, '(', $hmap[$frac], 0) . ')';
        }
        $hmap[$frac] = strlen($res);
    }

    return $res;
}
```
