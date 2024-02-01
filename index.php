<?php

class ListNode {
    public $val = 0;
    public $next = null;

    public function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

// Функция для поиска узла пересечения
function getIntersectionNode($headA, $headB) {
    if ($headA === null || $headB === null) {
        return null;
    }

    $pA = $headA;
    $pB = $headB;

    while ($pA !== $pB) {
        $pA = $pA === null ? $headB : $pA->next;
        $pB = $pB === null ? $headA : $pB->next;
    }

    return $pA;
}

// Создание узлов и списков
$intersect = new ListNode(8, new ListNode(4, new ListNode(5)));

// Первый список: 4 -> 1 -> 8 -> 4 -> 5
$headA = new ListNode(4, new ListNode(1, $intersect));

// Второй список: 5 -> 6 -> 1 -> 8 -> 4 -> 5
$headB = new ListNode(5, new ListNode(6, new ListNode(1, $intersect)));

// Вызов функции для поиска узла пересечения
$intersectionNode = getIntersectionNode($headA, $headB);

// Вывод результатов
if ($intersectionNode !== null) {
    echo "Пересечение в узле со значением: " . $intersectionNode->val . "\n";
} else {
    echo "Пересечений нет\n";
}
