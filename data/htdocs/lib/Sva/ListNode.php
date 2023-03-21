<?php

/**
 * Definition for a singly-linked list.
 */
namespace Sva;

class ListNode
{
    public $val = 0;
    public ?ListNode $next = null;

    public function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}
