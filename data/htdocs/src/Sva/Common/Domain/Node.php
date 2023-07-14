<?php

namespace Sva\Common\Domain;

class Node
{
    public $value;
    public $next;

    public function __construct($value)
    {
        $this->value = $value;
    }
}
