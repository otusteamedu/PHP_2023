<?php

declare(strict_types=1);

namespace App\Task1;

class ListNode
{
    public int $val = 0;
    public self|null $next = null;
    public function __construct($val)
    {
        $this->val = $val;
    }

    public function createFromArray(array $array): self
    {
        $head = $this;
        $head->val = $array[0];

        $temp = $head;
        array_shift($array);
        foreach ($array as $value) {
            $temp->next = new self($value);
            $temp = $temp->next;
        }

        return $head;
    }

    public function print(): void
    {
        $temp = $this;
        while ($temp->next) {
            echo $temp->val . ' ';
            $temp = $temp->next;
        }
        echo $temp->val . PHP_EOL;
    }
}

class Solution
{
    /**
     * @time O(2n)
     * @memory O(1)
     */
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        // Count length
        $lenA = 1;
        $lenB = 1;

        $tempA = $headA;
        while ($tempA->next) {
            $lenA++;
            $tempA = $tempA->next;
        }
        $tempB = $headB;
        while ($tempB->next) {
            $lenB++;
            $tempB = $tempB->next;
        }

        // Equalize the length of arrays
        $tempA = $headA;
        $tempB = $headB;
        while ($lenA !== $lenB) {
            if ($lenA > $lenB) {
                $tempA = $tempA->next;
                $lenA--;
            } else {
                $tempB = $tempB->next;
                $lenB--;
            }
        }

        // Find the intersection
        while ($tempA) {
            if ($tempA === $tempB) {
                return $tempA;
            }
            $tempA = $tempA->next;
            $tempB = $tempB->next;
        }
        return null;
    }
}

$listA = new ListNode(0);
$listA = $listA->createFromArray([4, 1, 8, 4, 5]);

$listB = new ListNode(0);
$listB = $listB->createFromArray([5, 6, 1]);
$listB->next->next->next = $listA->next->next;

$listA->print();
$listB->print();

$solution = new Solution();
$solution->getIntersectionNode($listA, $listB)->print();
