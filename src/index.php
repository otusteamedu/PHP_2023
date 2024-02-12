<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

use Klobkovsky\App\TwoLinkedLists\ListNode;
use Klobkovsky\App\TwoLinkedLists\Solution as Solution1;
use Klobkovsky\App\RecurringDecimal\Solution as Solution2;

echo <<<'HTML'
<h1>Результаты</h1>
<h2>Задача 1. Тест 1:</h2>
HTML;

$c1 = new ListNode(8);
$c2 = new ListNode(4);
$c3 = new ListNode(5);

$c1->next = $c2;
$c2->next = $c3;

$a1 = new ListNode(4);
$a2 = new ListNode(1);

$a1->next = $a2;
$a2->next = $c1;

$b1 = new ListNode(5);
$b2 = new ListNode(6);
$b3 = new ListNode(1);

$b1->next = $b2;
$b2->next = $b3;
$b3->next = $c1;

$result1 = Solution1::getIntersectionNode($a1, $b1);
var_export($result1);

echo <<<'HTML'
<h2>Задача 2. Тест 3:</h2>
HTML;

try {
    $result2 = Solution2::fractionToDecimal(4, 333);
    echo '<pre>';
    var_export($result2);
    echo '</pre>';
} catch (\Exception $exception) {
    echo $exception->getMessage();
}
