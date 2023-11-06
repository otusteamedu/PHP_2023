<?php

declare(strict_types=1);

namespace App\Task1;

class ListNode
{
    public int $val = 0;
    public ?self $next = null;

    public function __construct(int $val = 0, ?self $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }

    public static function createFromArray(array $values): ?self
    {
        if (empty($values)) {
            return null;
        }
        $dummyHead = new self(0);
        $current = $dummyHead;
        foreach ($values as $value) {
            $current->next = new self($value);
            $current = $current->next;
        }

        return $dummyHead->next;
    }

    public static function createCycle(array $values, int $pos): ?self
    {
        $head = self::createFromArray($values);
        if ($pos < 0) {
            return $head;
        }
        $tail = $head;
        $cycleNode = null;
        $index = 0;
        while ($tail->next !== null) {
            if ($index === $pos) {
                $cycleNode = $tail;
            }
            $tail = $tail->next;
            $index++;
        }
        $tail->next = $cycleNode;
        return $head;
    }
}

class Solution
{
    public function hasCycle(ListNode $head): bool
    {
        $hash = [];
        while ($head !== null) {
            $id = spl_object_id($head);
            if (isset($hash[$id])) {
                return true;
            }
            $hash[$id] = true;
            $head = $head->next;
        }
        return false;
    }
}

$solution = new Solution();

//$head = ListNode::createCycle([3, 2, 0, -4], 1);
//$head = ListNode::createCycle([1, 2], 0);
$head = ListNode::createCycle([1], -1);
echo 'Сложность: O(n)' . PHP_EOL;
echo 'Память: O(n)' . PHP_EOL;
echo 'Решение: ' . var_export($solution->hasCycle($head), true) . PHP_EOL;
