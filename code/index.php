<?php

require __DIR__ . '/vendor/autoload.php';

$service = new \Otus\Homework3\Service\BracketService();
$app = new \Otus\Homework3\App($service);

$brackets = $_REQUEST['string'] ?? null;

$result = $app->run($brackets);
if ($result) {
    echo 'Правильная скобочная последовательность';
} else {
    echo 'Неправильная скобочная последовательность';
}
