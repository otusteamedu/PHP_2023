<?php

declare(strict_types=1);

require __DIR__ . '/vendor/autoload.php';

$command = new \Vyacheslavlebedev\Php2023\Infrastructure\PalindromeCountCommand();
$command->execute();
