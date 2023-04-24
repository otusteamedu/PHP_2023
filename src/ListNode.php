<?php

namespace Yakovgulyuta\Hw6;

class ListNode
{
    public ?int $val = 0;
    public ?self $next = null;

    public function __construct(?int $val = 0, self $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
