<?php

class ListNode
{
    public int $val;
    public ?ListNode $next;

    public function __construct(int $val, ?ListNode $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

class MergeTwoLists
{
    private ?ListNode $node;
    private ?ListNode $node1;
    private ?ListNode $node2;

    public function __construct(ListNode $node1, ListNode $node2)
    {
        $this->node = new ListNode(0);
        $this->node1 = $node1;
        $this->node2 = $node2;
    }

    public function run(): self
    {
        $current = $this->node;
        while ($this->node1 !== null && $this->node2 !== null) {
            if ($this->node1->val < $this->node2->val) {
                $current->next = $this->node1;
                $this->node1 = $this->node1->next;
            } else {
                $current->next = $this->node2;
                $this->node2 = $this->node2->next;
            }

            $current = $current->next;
        }

        if ($this->node1 !== null) {
            $current->next = $this->node1;
        } elseif ($this->node2 !== null) {
            $current->next = $this->node2;
        }

        return $this;
    }

    public function showResultNode()
    {
        while($this->node !== null) {
            echo $this->node->val . PHP_EOL;
            $this->node = $this->node->next;
        }
    }
}

$l1 = new ListNode(1);
$l1->next = new ListNode(2);
$l1->next->next = new ListNode(4);

$l2 = new ListNode(1);
$l2->next = new ListNode(3);
$l2->next->next = new ListNode(4);


// Вызываем функцию слияния списков
(new MergeTwoLists($l1, $l2))->run()->showResultNode();
