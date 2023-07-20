<?php

declare(strict_types=1);

namespace Imitronov\Hw14\LinkedListCycle;

class ListNode
{
    public int $val = 0;

    public ?self $next = null;

    public function __construct(int $val)
    {
        $this->val = $val;
    }
}
