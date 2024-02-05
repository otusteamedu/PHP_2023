<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Yalanskiy\LeetCode\LinkedListCycle\Solution;
use Yalanskiy\LeetCode\LinkedListCycle\ListNode;

try {
    /* Set Test Data */
    $listValues = [3, -10, 2, 0, -5, 8, -19, 4];
    $listCyclePosition = 4;
    $listLen = count($listValues);

    $list = null;

    $lastNode = null;

    for ($idx = $listLen - 1; $idx >= 0; $idx--) {
        $listItem = new ListNode($listValues[$idx]);
        $listItem->next = $list;
        $list = $listItem;

        if ($lastNode === null) {
            $lastNode = $listItem;
        }
        if ($idx === $listCyclePosition) {
            $lastNode->next = $listItem;
        }
    }

    /* Check Cycled */
    $res = Solution::hasCycle($list);
    echo $res ? 'YES Cycle' : 'NO Cycle';
    echo PHP_EOL;
} catch (Exception $ex) {
    echo $ex->getMessage();
}
