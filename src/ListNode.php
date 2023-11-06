<?php

declare(strict_types=1);

namespace User\Php2023;

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
