<?php

namespace Sva\Common\App;

use Sva\Common\Domain\Node;

class LinkedListUtils
{
    public static function hasCycle(Node $head): bool
    {
        $slow = $head;
        $fast = $head;

        while (
            $slow->next != null
            && ($fast->next && $fast->next->next != null)
        ) {
            $slow = $slow->next;
            $fast = $fast->next->next;

            if ($slow === $fast) {
                return true;
            }
        }

        return false;
    }

    public static function createCycledLinkedList(): Node
    {
        $node5 = new Node(5);
        $node4 = new Node(4);
        $node4->next = $node5;
        $node3 = new Node(3);
        $node3->next = $node4;
        $node2 = new Node(2);
        $node2->next = $node3;
        $node1 = new Node(1);
        $node1->next = $node2;

        $node4->next = $node2;

        return $node1;
    }

    public static function createNonCycledLinkedList(): Node
    {
        $node5 = new Node(5);
        $node4 = new Node(4);
        $node4->next = $node5;
        $node3 = new Node(3);
        $node3->next = $node4;
        $node2 = new Node(2);
        $node2->next = $node3;
        $node1 = new Node(1);
        $node1->next = $node2;

        return $node1;
    }

    public static function getIntersect(Node $headA, Node $headB)
    {
        $tmpA = $headA;
        $tmpB = $headB;

        while($tmpA !== null) {
            while($tmpB !== null) {
                if ($tmpA === $tmpB) {
                    return $tmpA;
                }

                $tmpB = $tmpB->next;
            }

            $tmpA = $tmpA->next;
            $tmpB = $headB;
        }

        return [];
    }
}
