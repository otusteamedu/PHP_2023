<?php
class Solution {

    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode|null
     */
    public static function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        // Не лучшее решение по времени, за то хорошо по памяти. Оптимальные решения я конечно же посмотрел,
        // сам не догадался так сделать
        // В ключе хэша можно было использовать spl_object_hash($obj) и не складывать туда сами объекты списка,
        // что тоже вариант о котором я сам не догадался
        $copyA = $headA;
        $copyB = $headB;
        $vis = [];
        while ($copyA !== null) {
            $vis[] = $copyA;
            $copyA = $copyA->next;
        }
        while ($copyB !== null) {
            if (in_array($copyB, $vis, true)) {
                return $copyB;
            }
            $copyB = $copyB->next;
        }
        return null;
    }
}

class ListNode
{
    public int $val = 0;
    public ListNode|null $next = null;
    function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

$listA = new ListNode(4,
         new ListNode(1,
         new ListNode(8,
         new ListNode(4,
         new ListNode(5, null)))));

$listB = new ListNode(5,
         new ListNode(6,
         new ListNode(1, null)));

$listB->next->next->next = $listA->next->next;

print_r(Solution::getIntersectionNode($listA,$listB));

$listC = new ListNode(1,
         new ListNode(9,
         new ListNode(1,
         new ListNode(2,
         new ListNode(4, null)))));

$listD = new ListNode(3, null);

$listD->next = $listC->next->next->next;

print_r(Solution::getIntersectionNode($listC,$listD));