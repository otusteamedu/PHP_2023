<?php

namespace Sva;

class Solution
{
    /**
     * @param ListNode|null $list1
     * @param ListNode|null $list2
     * @return ListNode
     */
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2): ?ListNode
    {
        // Проверка если переданы 1 или меньше аргументов
        if (is_null($list1) && is_null($list2)) {
            return null;
        } elseif (is_null($list1)) {
            return $list2;
        } elseif (is_null($list2)) {
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
            if ($tmp1 && $tmp2) {
                if ($tmp1->val < $tmp2->val) {
                    $tmp3->next = new ListNode($tmp1->val);
                    $tmp1 = $tmp1->next;
                } else {
                    $tmp3->next = new ListNode($tmp2->val);
                    $tmp2 = $tmp2->next;
                }
            } elseif ($tmp1) {
                $tmp3->next = new ListNode($tmp1->val);
                $tmp1 = $tmp1->next;
            } elseif ($tmp2) {
                $tmp3->next = new ListNode($tmp2->val);
                $tmp2 = $tmp2->next;
            }

            $tmp3 = $tmp3->next;
        }

        return $list3;
    }

    /**
     * @param ListNode $list
     * @param ListNode $newNode
     * @return void
     * @deprecated
     */
    public function addToList(ListNode $list, ListNode $newNode)
    {
        if (is_null($list->next)) {
            $list->next = $newNode;
        } else {
            $temp = $list->next;
            
            while ($temp->next != null) {
                $temp = $temp->next;
            }
            
            $temp->next = $newNode;
        }
    }
}
