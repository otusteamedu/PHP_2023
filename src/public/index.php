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

/*
 * сложность будет O(n), т.к. нет вложенных циклов, сложность будет расти линейно при увеличении количества узлов в списке
 */
var_dump(hasCycle($head));

/*
 * сложность в худшем случае (для цифр 7 и 9, т.к. для них используются 4 буквы) будет равна O(n * 4^n). Для остальных цифр сложность составляет O(n * 3^n)
 */
var_dump(letterCombinations('23'));
