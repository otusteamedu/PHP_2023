<?php
declare(strict_types=1);

use Ekovalev\Otus\Helpers\Utilities;

require_once realpath(__DIR__ . '/../vendor/autoload.php');


$res = [
    Utilities::emailVerification('test@ya.ru'),
    Utilities::emailVerification('testya.ru'),
    Utilities::emailVerification('testya.ru11')
];


print_r($res);