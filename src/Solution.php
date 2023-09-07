<?php

namespace src;

class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2)
    {
        if (is_null($list1) && is_null($list2)) {
            return null;
        }
        if (is_null($list1) && (!is_null($list2))) {
            return $list2;
        }
        if ((!is_null($list1)) && (is_null($list2))) {
            return $list1;
        }

        $this->getTail($list1)->next = $list2;

        $newHead = new ListNode(null, null);
        $lastNode = $newHead;
        while ($nodeWithMin = $this->getNodeWithMinVal($list1)) {
            $lastNode->next = new ListNode($nodeWithMin->val, null);
            $lastNode = $lastNode->next;
            $nodeWithMin->val = null;
        }

        return $newHead->next;
    }

    private function getTail(?ListNode $node): ?ListNode
    {
        for (; $node->next; $node = $node->next) {
        }
        return $node;
    }
    private function getNodeWithMinVal(ListNode $node): ?ListNode
    {
        $min = 101;
        $nodeWithMin = null;
        while ($node) {
            if ((!is_null($node->val)) && ($node->val < $min)) {
                $min = $node->val;
                $nodeWithMin = $node;
            }
            $node = $node->next;
        }
        return $nodeWithMin;
    }
}
