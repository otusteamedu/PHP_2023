<?php

declare(strict_types=1);

use Application\Validator;

require __DIR__ . '/../vendor/autoload.php';

$string = '(())((()))';
$validator = new Validator();
$result = $validator->validate($string);

echo PHP_EOL . 'Код ответа: ' . http_response_code() . PHP_EOL;
echo $result . PHP_EOL;
