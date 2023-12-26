<?php

use App\ListNode;

function hasCycle(ListNode $head): bool {
    $fastNode = $head;

    while ($fastNode and $fastNode->next) {
        $head = $head->next;
        $fastNode = $fastNode->next->next;

        if ($head === $fastNode) {
            return true;
        }
    }

    return false;
}


/**
 * @return string[]
 */
function letterCombinations(string $digits): array {
    $lookup = [
        '2' => 'abc',
        '3' => 'def',
        '4' => 'ghi',
        '5' => 'jkl',
        '6' => 'mno',
        '7' => 'pqrs',
        '8' => 'tuv',
        '9' => 'wxyz',
    ];

    if (strlen($digits) === 0) {
        return [];
    }

    $output = [''];

    for($i = 0; $i < strlen($digits); $i++) {
        $tmp = [];
        $digit = $digits[$i];

        for($j = 0; $j < strlen($lookup[$digit]); $j++) {
            $char = $lookup[$digit][$j];

            for($k = 0; $k < count($output); $k++) {
                $tmp[] = $output[$k] . $char;
            }
        }

        $output = $tmp;
    }

    return $output;
}