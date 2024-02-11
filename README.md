# PHP_2023

https://otus.ru/lessons/razrabotchik-php/?utm_source=github&utm_medium=free&utm_campaign=otus

# Intersection of Two Linked Lists

сложность алгоритма O(n)
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
