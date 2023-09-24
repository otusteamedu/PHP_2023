<?php

namespace Rofflexor\Hw\Controllers;

use Rofflexor\Hw\Classes\ListNode;
use Rofflexor\Hw\Tasks\GenerateList;
use Rofflexor\Hw\Tasks\MergeListsTask;

class SortController
{


    public function handle(): bool|ListNode
    {
        $list1 = new ListNode(1);
        $list1->setNext(new ListNode(2))->setNext(new ListNode(4));

        $list2 = new ListNode(1);
        $list2->setNext(new ListNode(3))->setNext(new ListNode(4));

        $result =  (new MergeListsTask())->run($list1, $list2);

        if($result instanceof ListNode) {
            return $result;
        }
        return false;
    }


}