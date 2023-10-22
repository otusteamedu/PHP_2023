<?php

declare(strict_types=1);

namespace App\LinkedListCycle;

final class ListNode
{
    public int $val = 0;
    public ?ListNode $next = null;

    public function __construct(int $val)
    {
        $this->val = $val;
    }
}
