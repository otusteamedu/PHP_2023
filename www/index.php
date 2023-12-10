<?php

declare(strict_types=1);

include_once(__DIR__ . '/vendor/autoload.php');

use Singurix\Emailscheck\Checker;

$checker = new Checker();
$checker->start();
