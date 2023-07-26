<?php

declare(strict_types=1);

namespace Root\App;

class Solution
{
    /**
     * https://leetcode.com/problems/intersection-of-two-linked-lists/
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ?ListNode
     */
    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode
    {
        $node = [];
        while ($headA) {
            $node[] = $headA;
            $headA = $headA->next;
        }
        while ($headB) {
            if ($this->hasCycleSearch($node, $headB)) {
                return $headB;
            }
            $headB = $headB->next;
        }
        return null;
    }

    /**
     * https://leetcode.com/problems/fraction-to-recurring-decimal/
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal(int $numerator, int $denominator): string
    {
        if ($numerator === 0) {
            return '0';
        }
        if ($denominator === 0) {
            return '';
        }

        $maxLength = pow(10,4);
        $sign = ($numerator < 0 && $denominator >= 0) || ($numerator >= 0 && $denominator < 0) ? '-' : '';
        $numerator = abs($numerator);
        $denominator = abs($denominator);

        $remainder = [];
        $positions = [];

        $partInt = strval(intdiv($numerator, $denominator));
        $numerator = $numerator % $denominator;
        $maxLength = $maxLength - strlen($partInt) - 1/* . */;
        $partFloat = '';
        $partRepeated = '';

        $remainder[$numerator] = 1;
        $positions[$numerator] = 0;

        while (strlen($partFloat) < $maxLength && $numerator !== 0) {
            $numerator *= 10;
            $digit = intdiv($numerator, $denominator);
            $numerator = $numerator % $denominator;

            if (!isset($remainder[$numerator])) {
                $remainder[$numerator] = 1;
                $partFloat .= $digit;
                $positions[$numerator] = strlen($partFloat);
            } else {
                $remainder[$numerator]++;
                $partFloat .= $digit;
                $partRepeated = substr($partFloat, $positions[$numerator]);
                $partFloat = substr($partFloat, 0, $positions[$numerator]);
                break;
            }
        }

        $partDecimal =  $partFloat . (!empty($partRepeated) ? '('. $partRepeated .')' : '');
        return $sign . $partInt . (!empty($partDecimal) ? '.'. $partDecimal : '');
    }


    /**
     * https://leetcode.com/problems/linked-list-cycle/
     * @param ListNode|null $head
     * @return Boolean
     */
    public function hasCycle(?ListNode $head): bool
    {
        $elements = [];

        while ($head != null) {
            if ($this->hasCycleSearch($elements, $head) === false) {
                $elements[] = $head;
                $head = $head->next;
            } else {
                return true;
            }
        }
        return false;
    }
    private function hasCycleSearch(array $array, ?ListNode $element): bool
    {
        if (count($array) === 0) {
            return false;
        }
        foreach ($array as $item) {
            if ($item === $element) {
                return true;
            }
        }
        return false;
    }

    /**
     * https://leetcode.com/problems/letter-combinations-of-a-phone-number/
     * @param String $digits
     * @return String[]
     */
    public function letterCombinations(string $digits): array
    {
        $ret = [];
        if ($digits === '') {
            return [];
        }

        $h = $this->letterCombinationsMap(substr($digits, 0, 1));
        $t = $this->letterCombinations(substr($digits, 1));
        foreach ($h as $f) {
            if (empty($t)) {
                $ret[] = $f;
            } else {
                foreach ($t as $l) {
                    $ret[] = $f . $l;
                }
            }
        }
        return $ret;
    }
    private function letterCombinationsMap(string $char): array
    {
        $map = [
            '2' => ['a', 'b', 'c'],
            '3' => ['d', 'e', 'f'],
            '4' => ['g', 'h', 'i'],
            '5' => ['j', 'k', 'l'],
            '6' => ['m', 'n', 'o'],
            '7' => ['p', 'q', 'r', 's'],
            '8' => ['t', 'u', 'v'],
            '9' => ['w', 'x', 'y', 'z']
        ];
        return $map[$char] ?? [];
    }

    public function listToString(?ListNode $list = null): string
    {
        if ($list === null) {
            return 'null';
        }
        $max = 10;
        $cnt = 0;

        $arr = [];
        while ($list !== null && $cnt < $max) {
            $arr[] = $list->val;
            $list = $list->next;
            $cnt++;
        }
        return implode(', ', $arr);
    }

    public function arrayToString(?array $array): string
    {
        if (is_null($array)) {
            return 'null';
        }
        return '[' . implode(', ', $array) . ']';
    }
    public function compareArray(?array $in, ?array $expected, int $length = 0): bool
    {
        if (($in === null || $expected === null) && $length === 0) {
            return true;
        }
        if (count($expected) === $length) {
            if ($in !== null && $expected !== null && count($in) >= $length) {
                for ($i = 0; $i < $length; $i++) {
                    if (!isset($in[$i]) || !isset($expected[$i]) || $in[$i] !== $expected[$i]) {
                        return false;
                    }
                }
                return true;
            }
        }
        return false;
    }
}
