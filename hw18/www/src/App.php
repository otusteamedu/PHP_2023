<?php
declare(strict_types=1);

namespace Shabanov\Otusphp;

class App
{
    private const LIST_A = [4,1,8,4,5];
    private const LIST_B = [5,6,1,8,4,5];
    private const NUMERATOR = 5;
    private const DENUMERATOR = 8;
    public function __construct() {}

    public function __invoke(): void
    {
        /**
         * Задача №1 с пересечением списков
         */
        $this->task1();

        /**
         * Задача №2 про дроби
         */
        echo $this->task2();
    }

    private function task1(): void
    {
        $listA = ListNode::createFromArray(self::LIST_A);
        $listB = ListNode::createFromArray(self::LIST_B);
        print_r(ListNode::getIntersectionNode($listA, $listB));
    }

    private function task2(): string
    {
        $quotient = floor(self::NUMERATOR / self::DENUMERATOR);
        $remainder = self::NUMERATOR % self::DENUMERATOR;

        if ($remainder === 0) {
            return strval($quotient);
        }

        $fractionalPart = "";
        $remainders = [];
        $repeatIndex = -1;

        while ($remainder !== 0) {
            if (isset($remainders[$remainder])) {
                $repeatIndex = $remainders[$remainder];
                break;
            }

            $remainders[$remainder] = strlen($fractionalPart);

            $remainder *= 10;
            $fractionalPart .= strval(floor($remainder / self::DENUMERATOR));

            $remainder %= self::DENUMERATOR;
        }

        if ($repeatIndex >= 0) {
            $fractionalPart = substr($fractionalPart, 0, $repeatIndex) . '(' . substr($fractionalPart, $repeatIndex) . ')';
        }

        return $quotient . '.' . $fractionalPart;
    }
}
