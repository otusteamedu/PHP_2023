<?php

namespace App\Helpers;

use App\ListNode;

class Functions
{
    /**
     * @param Integer $numerator
     * @param Integer $denominator
     * @return String
     */
    public function fractionToDecimal(int $numerator, int $denominator): string // Сложность - O(n), где n соответвует количество цифр в дробной части
    {
        if ($numerator === 0) {
            return '0';
        }

        $result[] = strval(intval($numerator / $denominator));

        $remainder = $numerator % $denominator;

        if ($remainder === 0) {
            return implode('', $result);
        }

        $result[] = '.';

        $remainderDict = [];
        while ($remainder !== 0) {
            if (array_key_exists($remainder, $remainderDict)) {
                array_splice($result, $remainderDict[$remainder], 0, '(');
                $result[] = ')';
                break;
            }

            $remainderDict[$remainder] = count($result);

            $remainder *= 10;
            $result[] = strval(abs(intval($remainder / $denominator)));
            $remainder %= $denominator;
        }

        return implode('', $result);
    }

    public function getIntersectionNode(ListNode $headA, ListNode $headB): ?ListNode // Сложность - O(n + m), где n,m - длины списков
    {
        $pointerA = $headA;
        $pointerB = $headB;

        while ($pointerA !== $pointerB) {
            $pointerA = ($pointerA === null) ? $headB : $pointerA->next;
            $pointerB = ($pointerB === null) ? $headA : $pointerB->next;
        }

        return $pointerA;
    }
}
