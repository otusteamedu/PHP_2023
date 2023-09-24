<?php

namespace Rofflexor\Hw\Tasks;

use Rofflexor\Hw\Classes\ListNode;

class MergeListsTask
{

    public function run(ListNode $listNode1, ListNode $listNode2) {
        $head = $tail = new ListNode();
        while (isset($listNode1, $listNode2)) {
            if ($listNode1->getVal() < $listNode2->getVal()) {
                $tail->setNext($listNode1);
                $listNode1 = $listNode1->getNext();
            } else {
                $tail->setNext($listNode2);
                $listNode2 = $listNode2->getNext();
            }
            $tail = $tail->getNext();
        }
        $tail->setNext($listNode1 ?? $listNode2);
        return $head->getNext();

    }


}