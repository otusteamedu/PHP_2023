<?php

namespace Classes;

class ListNode
{
    public function __construct(public $val = 0, public $next = null)
    {
        $this->val = $val;
    }
}
