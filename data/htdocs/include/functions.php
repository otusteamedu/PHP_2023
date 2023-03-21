<?php

function printList(?Sva\ListNode $node): void
{
    if ($node != null) {
        echo "\nThe list contains: ";
        while ($node != null) {
            echo $node->val . " ";
            $node = $node->next;
        }
    } else {
        echo "\nThe list is empty.";
    }
}
