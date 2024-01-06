<?php

declare(strict_types=1);


use App\Services\StringService;

require_once __DIR__ . '/vendor/autoload.php';



print('Домашнее задание hw3' . '<br>');
echo date("Y-m-d H:i:s") . '<br><br>';

print( "кол символов в слове " . '\'строка\' = ');

$stringService = new StringService();
$countChar = $stringService->getLenString('строка');

echo (string)$countChar;
