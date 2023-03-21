<?php

function printList(?ListNode $node): void
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

/**
 * Definition for a singly-linked list.
 */
class ListNode
{
    public $val = 0;
    public ?ListNode $next = null;

    public function __construct($val = 0, $next = null)
    {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution
{

    /**
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode
     */
    function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode {
        // Проверка если переданы 1 или меньше аргументов
        if(is_null($list1) && is_null($list2)) {
            return null;
        } elseif(is_null($list1)) {
            return $list2;
        } elseif(is_null($list2)) {
            return $list1;
        }

        // Определяем в каком списке первый элемент меньше с того и начнём работу
        if ($list2->val >= $list1->val) {
            $tmp1 = $list1;
            $tmp2 = $list2;
        } else {
            $tmp1 = $list2;
            $tmp2 = $list1;
        }

        $list3 = new ListNode($tmp1->val);
        $tmp1 = $tmp1->next;
        $tmp3 = $list3;

        while ($tmp1 || $tmp2) {
            if($tmp1 && $tmp2) {
                if($tmp1->val < $tmp2->val) {
                    $tmp3->next = new ListNode($tmp1->val);
                    $tmp1 = $tmp1->next;
                } else {
                    $tmp3->next = new ListNode($tmp2->val);
                    $tmp2 = $tmp2->next;
                }
            } elseif($tmp1) {
                $tmp3->next = new ListNode($tmp1->val);
                $tmp1 = $tmp1->next;
            } elseif($tmp2) {
                $tmp3->next = new ListNode($tmp2->val);
                $tmp2 = $tmp2->next;
            }

            $tmp3 = $tmp3->next;
        }

        return $list3;
    }

    /**
     * @deprecated
     * @param ListNode $list
     * @param ListNode $newNode
     * @return void
     */
    public function addToList(ListNode $list, ListNode $newNode)
    {
        if (is_null($list->next)) {
            $list->next = $newNode;
        } else {
            $temp = $list->next;
            while ($temp->next != null)
                $temp = $temp->next;
            $temp->next = $newNode;
        }
    }
}

$solution = new Solution();
$list1 = new ListNode(1);
$solution->addToList($list1, new ListNode(2));
$solution->addToList($list1, new ListNode(4));

$list2 = new ListNode(1);
$solution->addToList($list2, new ListNode(3));
$solution->addToList($list2, new ListNode(4));

$first3 = $solution->mergeTwoLists($list1, $list2);

printList($list1);
printList($list2);

printList($first3);

echo "\n----";

$solution = new Solution();
$list1 = null;
$list2 = new ListNode(0);

$first3 = $solution->mergeTwoLists($list1, $list2);

printList($list1);
printList($list2);

printList($first3);

echo "\n----";

$solution = new Solution();
$list1 = new ListNode(2);;
$list2 = new ListNode(1);

$first3 = $solution->mergeTwoLists($list1, $list2);

printList($list1);
printList($list2);

printList($first3);

echo "\n----";

$solution = new Solution();
$list1 = new ListNode(-9);;
$solution->addToList($list1, new ListNode(3));

$list2 = new ListNode(5);
$solution->addToList($list2, new ListNode(7));

$first3 = $solution->mergeTwoLists($list1, $list2);

printList($list1);
printList($list2);

printList($first3);
