<?php

use Sva\Common\Domain\Node;

return [
    'default' => function () {
        $nodeA5 = new Node(5);
        $nodeA4 = new Node(4);
        $nodeA4->next = $nodeA5;
        $nodeA3 = new Node(3);
        $nodeA3->next = $nodeA4;
        $nodeA2 = new Node(2);
        $nodeA2->next = $nodeA3;
        $nodeA1 = new Node(1);
        $nodeA1->next = $nodeA2;


        $nodeB1 = new Node(16);
        $nodeB2 = new Node(18);
        $nodeB3 = new Node(18);

        $nodeB1->next = $nodeB2;
        $nodeB2->next = $nodeB3;
        $nodeB2->next = $nodeA3;

        \Sva\Common\App\LinkedListUtils::getIntersect($nodeA1, $nodeB1);
    },
    'fractionToDecimal' => function () {
        function fractionToDecimal($numerator, $denominator): string
        {
            if ($numerator == 0) {
                return "0";
            }

            $result = "";

            // Определяем знак результата
            if (($numerator < 0) ^ ($denominator < 0)) {
                $result .= "-";
            }

            $numerator = abs($numerator);
            $denominator = abs($denominator);

            $result .= intdiv($numerator, $denominator);
            $remainder = $numerator % $denominator;

            if ($remainder == 0) {
                return $result;
            }

            $result .= '.';
            $fraction = '';
            $map = [];
            while ($remainder != 0) {
                if (isset($map[$remainder])) {
                    $start = $map[$remainder];
                    $nonRepeatingPart = substr($fraction, 0, $start);
                    $repeatingPart = substr($fraction, $start);
                    return $result . $nonRepeatingPart . "(" . $repeatingPart . ")";
                }

                $map[$remainder] = strlen($fraction);
                $remainder *= 10;
                $fraction .= floor($remainder / $denominator);
                $remainder %= $denominator;
            }

            return $result . $fraction;
        }

        echo fractionToDecimal(-50, 8) . PHP_EOL;
        echo fractionToDecimal(1, 6) . PHP_EOL;
        echo fractionToDecimal(2, 3) . PHP_EOL;
        echo fractionToDecimal(1, 2) . PHP_EOL;
        echo fractionToDecimal(2, 1) . PHP_EOL;
        echo fractionToDecimal(4, 333) . PHP_EOL;
    }
];
