<?php

namespace App;

/**
 * Definition for a singly-linked list
 */
class ListNode
{
    /** @var int  */
    public $val = 0;

    /** @var ListNode|null  */
    public $next = null;

    public function __construct(int $val)
    {
        $this->val = $val;
    }
}
