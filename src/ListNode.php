<?php

declare(strict_types=1);

namespace DOlshev\Hw;

class ListNode
{
    public function __construct(public int $val = 0, public ListNode | null $next = null)
    {
    }
}
