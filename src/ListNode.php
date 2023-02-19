<?php

declare(strict_types=1);

namespace Twent\Hw6;

final class ListNode
{
    public function __construct(
        public int $val = 0,
        public ?self $next = null
    ) {
    }
}
