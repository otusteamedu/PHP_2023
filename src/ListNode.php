<?php

declare(strict_types=1);

namespace User\Php2023;

class ListNode
{
    public int $val = 0;
    public $next = null;

    public function __construct(int $val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
