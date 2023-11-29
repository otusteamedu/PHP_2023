<?php

declare(strict_types=1);

require(__DIR__ . '/src/input.php');

if ($_POST) {
    require_once('api.php');
} else {
    require_once('view.php');
}