<?php

declare(strict_types=1);

use Singurix\Checkinput\Input;

require(__DIR__ . '/src/input.php');

if ($_POST) {
    $checker = new Input($_POST);
    echo $checker->check();
}
