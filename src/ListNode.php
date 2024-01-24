<?php

namespace App;

class ListNode {
    public int $val = 0;
    public ?ListNode $next = null;
    function __construct(int $val) { $this->val = $val; }
}
