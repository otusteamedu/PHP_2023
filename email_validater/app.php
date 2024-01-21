<?php

declare(strict_types=1);

use Kanakhin\EmailValidation\Application\EmailValidater;

require __DIR__ . '/vendor/autoload.php';

try {
    $validater = new EmailValidater();
    $validater->run($argv);
} catch (\Exception $e) {

}
