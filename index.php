<?php
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
    function hasCycle($head)
    {
        if ($head == null || $head->next == null) {
            return false;
        }

        $slow = $head;
        $fast = $head->next;

        while ($slow != $fast) {

            if ($fast == null || $fast->next == null) {
                return false;
            }

            $slow = $slow->next;
            $fast = $fast->next->next;
        }

        return true;
    }
}


class Solution2
{

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits)
    {
        if (empty($digits)) {
            return []; // возвращаем пустой массив для пустой строки ввода
        }

        $digitMap = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z'],
        ];

        $result = [];
        $currentCombination = '';

        $this->generateCombinations($digits, 0, $digitMap, $currentCombination, $result);

        return $result;
    }

    function generateCombinations($digits, $index, $digitMap, $currentCombination, &$result)
    {
        if ($index == strlen($digits)) {
            $result[] = $currentCombination;
            return;
        }

        $currentDigit = $digits[$index];
        $letters = $digitMap[$currentDigit];

        foreach ($letters as $letter) {
            $this->generateCombinations($digits, $index + 1, $digitMap, $currentCombination . $letter, $result);
        }
    }
}