<?php

declare(strict_types=1);

use Singurix\Emailscheck\Checker;

if ($_POST) {
    $checker = new Checker($_POST['emails']);
    echo json_encode($checker->check());
} else {
    require_once(__DIR__ . '/view.php');
}
