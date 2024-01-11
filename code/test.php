<?php

declare(strict_types=1);

use App\LetterCombinations\LetterCombinations;
use App\LinkedListCycle\LinkedListCycle;
use App\LinkedListCycle\ListNode;

require __DIR__ . '/vendor/autoload.php';

echo '141. Linked List Cycle' . PHP_EOL;

$head = ListNode::createCycle([3, 2, 0, -4], 1);
$linkedListCycle = new LinkedListCycle($head);
var_dump($linkedListCycle->hasCycle($head));

echo PHP_EOL . '17. Letter Combinations of a Phone Number' . PHP_EOL;

$num = '23';
$letterCombinations = new LetterCombinations();
print_r($letterCombinations->letterCombinations($num));
