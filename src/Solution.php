<?php

namespace src;


class Solution
{
    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists($list1, $list2) {
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
        $min = $this->getMin($list1);
        while ($min !== 101) {
            $this->getTail($newHead)->next = new ListNode($min, null);
            $this->updateByVal($min, $list1);
            $min = $this->getMin($list1);
        }

        return $newHead->next;
    }

    private function getTail(?ListNode $node): ?ListNode
    {
        for (; $node->next; $node = $node->next) {
        }
        return $node;
    }
    private function updateByVal(int $val, ListNode $node): bool
    {
        while ($node) {
            if ($val === $node->val) {
                $node->val = null;
                return true;
            }
            $node = $node->next;
        }
        return false;
    }
    private function getMin(ListNode $node): int
    {
        $min = 101;
        while ($node) {
            $min = (!is_null($node->val)) ? min($min, $node->val) : $min;
            $node = $node->next;
        }
        return $min;
    }
}
