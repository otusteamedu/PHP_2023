<?php

class Solution
{
    private $list_work1;
    private $list_work2;
    private $merge_work;
    private $merge;

    function mergeTwoLists($list1, $list2)
    {

        if ($list1 === NULL) {
            $this->merge = $list2;
            $this->list_work2 = NULL;
        } else if ($list2 === NULL) {
            $this->merge = $list1;
            $this->list_work1 = NULL;
        } else {
            $node_min = $this->min($list1, $list2); // минимальный узел из первых в списке
            $node_max = $this->max($list1, $list2); // максимальный узел из первых в списке (остается для сравнения)

            $this->merge = new ListNode($node_min->val, NULL);

            $this->list_work1 = $node_min->next;
            $this->list_work2 = $node_max;
            $this->merge_work = $this->merge;
        }

        while ($this->list_work1 !== null || $this->list_work2 !== null) {
            $cr = $this->createNode($this->list_work1, $this->list_work2, $this->merge_work);
        }

        return $this->merge;

    }

    public function createNode($list1, $list2, $merge_work)
    {
        if ($list1 === NULL) {
            $merge_work->next = $list2;
            $this->list_work2 = NULL;
        } else if ($list2 === NULL) {
            $merge_work->next = $list1;
            $this->list_work1 = NULL;
        } else {
            $node_min = $this->min($list1, $list2); // минимальный узел из первых в списке
            $merge_work->next = new ListNode($node_min->val, NULL);
            $node_max = $this->max($list1, $list2); // максимальный узел из первых в списке (остается для сравнения)

           // переопределяю узлы
            $this->list_work1 = $node_min->next;
            $this->list_work2 = $node_max;
            $this->merge_work = $merge_work->next;
        }

        return true;
    }

    public function min($list1, $list2)
    {
        if ($list1->val <= $list2->val) {
            $result = $list1;
        } else {
            $result = $list2;
        }

        return $result;
    }

    public function max($list1, $list2)
    {
        if ($list1->val > $list2->val) {
            return $list1;
        } else {
            return $list2;
        }
    }


}