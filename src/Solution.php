<?php

namespace Rvoznyi\ComposerHello;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2): ?ListNode
    {
        $listNode = [];
        $node = $list1;
        while (is_numeric($node->val)) {
            $listNode[] = $node->val;
            $node = $node->next;
        }
        $node = $list2;
        while (is_numeric($node->val)) {
            $listNode[] = $node->val;
            $node = $node->next;
        }
        sort($listNode);
        $len = count($listNode);
        $node = null;
        if ($len > 0) {
            $node = new ListNode($listNode[$len - 1]);
            --$len;
            while ($len > 0) {
                --$len;
                $tmpNode = new ListNode($listNode[$len], $node);
                $node = $tmpNode;
            }
        }
        return $node;
    }
}
