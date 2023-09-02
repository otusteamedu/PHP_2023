<?php

declare(strict_types=1);

final class ListNode
{
    public function __construct(
        public int $val = 0,
        public ListNode|null $next = null,
    ) {
    }
}

final class Solution
{
    /**
     * Моё первое самостоятельное решение в лоб
     * Алгоритмическая сложность квадратическая, так как для каждого листа $headA мы проходимся по целому списку $headB
     */
    public function getIntersectionNodeFirstSolution(ListNode $headA, ListNode $headB): ListNode|null
    {
        while (null !== $headA) {
            $current = $headB;
            while (null !== $current) {
                if ($headA === $current) {
                    return $headA;
                }

                $current = $current->next;
            }

            $headA = $headA->next;
        }

        return null;
    }

    /**
     * Немного подумав я решил что можно одновременно начинать идти по двум спискам,
     * но я не догадался как продолжить цикл, если один из списков дошёл до конца.
     * Поэтому немного погуглив нашёл такое решение, когда мы перескакиваем на другой список и цикл продолжается.
     *
     * Алгоритмическая сложность такого решения - линейная.
     */
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ListNode|null
    {
        $listA = $headA;
        $listB = $headB;

        while ($listA !== $listB) {
            $listA = $listA === null ? $headB : $listA->next;
            $listB = $listB === null ? $headA : $listB->next;
        }

        return $listA;
    }
}

$solution = new Solution();

$intersectedLinkedList = new ListNode(
    8,
    new ListNode(
        4,
        new ListNode(5)
    )
);

$headA = new ListNode(
    4,
    new ListNode(
        1,
        $intersectedLinkedList,
    )
);

$headB = new ListNode(
    5,
    new ListNode(
        6,
        new ListNode(
            1,
            $intersectedLinkedList,
        )
    )
);

echo $solution->getIntersectionNode($headA, $headB)->val . PHP_EOL;
