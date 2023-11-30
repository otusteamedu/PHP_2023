<?php

declare(strict_types=1);

include_once(__DIR__ . '/vendor/autoload.php');

if ($_POST) {
    require_once(__DIR__ . '/app.php');
} else {
    require_once(__DIR__ . '/view.php');
}
