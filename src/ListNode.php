<?php

namespace App;

class ListNode
{
    /** @var int  */
    public $val = 0;

    /** @var null|ListNode  */
    public $next = null;

    public function __construct(int $val)
    {
        $this->val = $val;
    }
}
