<?php

declare(strict_types=1);

use Yalanskiy\Lists\ListNode;
use Yalanskiy\Lists\Output;
use Yalanskiy\Lists\Solution;

require_once __DIR__ . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/* Fill test lists */
$list1values = [-35, -10, -2, 0, 5, 8, 19, 49];
$list2values = [-21, -11, -7, -4, -2, 3, 7, 19, 23, 45, 50];
$list1Len = count($list1values);
$list2Len = count($list2values);

$list1 = null;
$list2 = null;

for ($idx = $list1Len - 1; $idx >= 0; $idx--) {
    $listItem = new ListNode($list1values[$idx], $list1);
    $list1 = $listItem;
}

for ($idx = $list2Len - 1; $idx >= 0; $idx--) {
    $listItem = new ListNode($list2values[$idx], $list2);
    $list2 = $listItem;
}

echo 'List 1:' . PHP_EOL;
Output::print($list1, ' | ');
echo '===========================================================' . PHP_EOL;
echo 'List 2:' . PHP_EOL;
Output::print($list2, ' | ');
echo '===========================================================' . PHP_EOL;

$listMerged = Solution::mergeTwoLists($list1, $list2);
echo 'Merged List:' . PHP_EOL;
Output::print($listMerged, ' | ');
