<?php

declare(strict_types=1);

use Singurix\Emailscheck\Checker;

require(__DIR__ . '/vendor/autoload.php');

if ($_POST['emails']) {
    $checker = new Checker($_POST['emails']);
    echo json_encode($checker->check());
}
