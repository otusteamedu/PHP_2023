<?php

declare(strict_types=1);

namespace Yalanskiy\LeetCode\LinkedListCycle;

/**
 * Class ListNode
 */
class ListNode
{
    public int $val = 0;
    public ?ListNode $next = null;

    /**
     * @param $val
     */
    public function __construct($val)
    {
        $this->val = $val;
    }
}
