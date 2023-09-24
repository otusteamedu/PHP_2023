<?php

namespace Rofflexor\Hw\Classes;

class ListNode
{

    private int $val;
    private ?ListNode $next;

    public function __construct(int $val = 0, ?ListNode $next = null
    )
    {
        $this->val = $val;
        $this->next = $next;
    }

    public function getVal(): int
    {
        return $this->val;
    }

    public function getNext(): ?ListNode
    {
        return $this->next;
    }

    public function setNext(?ListNode $listNode): static
    {
       $this->next = $listNode;
       return $listNode;
    }


}