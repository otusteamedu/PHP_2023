<?php

namespace Vendor\class;

/**
 * url task https://leetcode.com/problems/linked-list-cycle/solutions/
 * сложность линейная, нет повторных прохождений по одним и тем же элементам списка
 */

/**
 * Definition for a singly-linked list.
 * class ListNode {
 *     public $val = 0;
 *     public $next = null;
 *     function __construct($val) { $this->val = $val; }
 * }
 */

class Solution
{
    /**
     * @param ListNode $head
     * @return Boolean
     */
    public function hasCycle($head)
    {
        $hash = [];
        $res = false;
        $currHead = $head;
        while ($currHead->next) {
            $hashNode = spl_object_hash($currHead);
            if (isset($hash[$hashNode])) {
                $res = true;
                return $res;
            }
            $hash[$hashNode] = true;
            $currHead = $currHead->next;
        }
        return $res;
    }
}
