<?php

declare(strict_types=1);

namespace DEsaulenko\Hw18\Intersection;

use DEsaulenko\Hw18\ListNode;

require_once 'vendor/autoload.php';

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */
class Solution
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    public function getIntersectionNode($headA, $headB)
    {
        if ($headA === $headB) {
            return $headA;
        }
        $lengthHeadA = $this->getLength($headA);
        $lengthHeadB = $this->getLength($headB);
        if ($lengthHeadA > $lengthHeadB) {
            return $this->findIntersection($headA, $headB, $lengthHeadA - $lengthHeadB);
        }
        return $this->findIntersection($headB, $headA, $lengthHeadB - $lengthHeadA);
    }

    protected function findIntersection(ListNode $first, ListNode $second, int $count): ?ListNode
    {
        for ($i = 0; $i < $count; $i++) {
            $first = $first->next;
        }
        while (
            $first
            && $second
        ) {
            if ($first === $second) {
                return $first;
            }
            $first = $first->next;
            $second = $second->next;
        }
        return null;
    }

    protected function getLength(ListNode $list)
    {
        $count = 0;
        while ($list !== null) {
            ++$count;
            $list = $list->next;
        }
        return $count;
    }
}
