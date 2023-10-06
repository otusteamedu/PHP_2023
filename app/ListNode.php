<?php

declare(strict_types=1);

namespace App;

final class ListNode
{
    public int $val = 0;

    public ?self $next = null;

    public function __construct(int $val)
    {
        $this->val = $val;
    }
}
