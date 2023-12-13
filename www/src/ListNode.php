<?php

declare(strict_types=1);

namespace Yalanskiy\Lists;

/**
 * Class for One List Node
 */
class ListNode
{
    public int $val = 0;
    public ?ListNode $next = null;

    /**
     * Create list node
     *
     * @param int $val
     * @param ListNode|null $next
     */
    public function __construct(int $val = 0, ListNode $next = null)
    {
        $this->val  = $val;
        $this->next = $next;
    }
}
