<?php

declare(strict_types=1);

class ListNode
{
    function __construct(
        private readonly int $val,
        private ListNode|null $next = null,
    ) {
    }

    public function getVal(): int
    {
        return $this->val;
    }

    public function getNext(): ?ListNode
    {
        return $this->next;
    }

    public function setNext(?ListNode $next): void
    {
        $this->next = $next;
    }

    public function hasNext(): bool
    {
        return $this->next !== null;
    }
}

class Solution
{
    /**
     * Сложность этого алгоритма O(n)
     */
    public function __construct(
        private WeakMap $weakHash = new WeakMap(),
    ) {
    }


    function hasCycleWithWeakMap(ListNode $head): bool
    {
        if ($this->weakHash->offsetExists($head)) {
            return true;
        }

        $this->weakHash[$head] = 'something';

        if ($head->hasNext()) {
            return $this->hasCycleWithWeakMap($head->getNext());
        }

        return false;
    }
}

$firstNode = new ListNode(3);
$secondNode = new ListNode(2);
$thirdNode = new ListNode(0);
$fourthNode = new ListNode(-4);

$firstNode->setNext($secondNode);
$secondNode->setNext($thirdNode);
$thirdNode->setNext($fourthNode);
$fourthNode->setNext($secondNode);

$hasCycle = (new Solution())->hasCycleWithWeakMap($firstNode);

var_dump($hasCycle);
