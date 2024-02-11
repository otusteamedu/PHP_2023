<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Klobkovsky\App\LinkedListCycle\ListNode;
use Klobkovsky\App\LinkedListCycle\Solution as Solution1;
use Klobkovsky\App\LetterCombinations\Solution as Solution2;

echo <<<'HTML'
<h1>Результаты</h1>
<h2>Задача 1. Тест 1:</h2>
HTML;

$head = new ListNode(3);
$node1 = new ListNode(2);
$node2 = new ListNode(0);
$node3 = new ListNode(-4);

$head->next = $node1;
$node1->next = $node2;
$node2->next = $node3;
$node3->next = $node1; // pos=1

$result1 = Solution1::hasCycle($head);
echo 'Список [3, 2, 0, 1]' . ($result1 ? '' : ' не') . ' содержит цикл';

echo <<<'HTML'
<h2>Задача 2. Тест:</h2>
HTML;

try {
    $result2 = Solution2::letterCombinations('23');
    echo '<pre>';
    var_export($result2);
    echo '</pre>';
} catch (\Exception $exception) {
    echo $exception->getMessage();
}
