<?php

require_once __DIR__ . '/../../vendor/autoload.php';

use App\ListNode;

include __DIR__ . '/../helpers.php';

$nodeFist = new ListNode(1);
$nodeSecond = new ListNode(2);
$nodeThird = new ListNode(3);

$nodeFist->next = $nodeSecond;
$nodeSecond->next = $nodeThird;
$nodeThird->next = $nodeFist;

$head = $nodeFist;

var_dump(hasCycle($head));
var_dump(letterCombinations('23'));
