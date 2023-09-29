<?php

namespace Classes;

class ListNode
{
    function __construct(public $val = 0, public $next = null)
    {
        $this->val = $val;
    }
}
