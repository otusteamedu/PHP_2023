<?php


class Solution
{

    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    function fractionToDecimal($numerator, $denominator)
    {
        if ($numerator == 0) {
            return "0";
        }

        $result = '';

        if (($numerator < 0) ^ ($denominator < 0)) {
            $result .= '-';
        }

        $numerator = abs($numerator);
        $denominator = abs($denominator);
        $result .= (string)(int)($numerator / $denominator);

        $remainder = $numerator % $denominator;
        if ($remainder == 0) {
            return $result;
        }

        $result .= '.';

        $fractionalPart = [];
        $map = [];

        while ($remainder != 0) {
            if (isset($map[$remainder])) {
                $startIndex = $map[$remainder];
                $nonRepeatingPart = implode('', array_slice($fractionalPart, 0, $startIndex));
                $repeatingPart = implode('', array_slice($fractionalPart, $startIndex));
                return $result . $nonRepeatingPart . '(' . $repeatingPart . ')';
            }

            $map[$remainder] = count($fractionalPart);
            $remainder *= 10;
            $fractionalPart[] = (string)(int)($remainder / $denominator);
            $remainder %= $denominator;
        }

        return $result . implode('', $fractionalPart);
    }
}


class Solution2
{
    /**
     * @param ListNode $headA
     * @param ListNode $headB
     * @return ListNode
     */
    function getIntersectionNode($headA, $headB)
    {
        $pointerA = $headA;
        $pointerB = $headB;

        while ($pointerA !== $pointerB) {
            $pointerA = $pointerA ? $pointerA->next : $headB;
            $pointerB = $pointerB ? $pointerB->next : $headA;

            if ($pointerA === $pointerB) {
                return $pointerA;
            }
        }

        return $pointerA;
    }
}