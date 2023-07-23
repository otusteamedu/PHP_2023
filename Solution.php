<?php

declare(strict_types=1);

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

/**
 * @param ListNode $head
 * @return Boolean
 */
function hasCycle(ListNode $head): bool
{
    $arViewedNodes = [];
    $viewedNodesCount = 0;

    do {
        for ($i = 0; $i < $viewedNodesCount; $i++) {
            if ($head === $arViewedNodes[$i]) {
                return true;
            }
        }

        $arViewedNodes[] = $head;
        $viewedNodesCount++;
    } while (($head = $head->next) !== null);

    return false;
}
