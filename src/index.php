<?php

declare(strict_types=1);

require_once __DIR__ . '/Models/StringValidator.php';
require_once __DIR__ . '/Controllers/StringController.php';

use Controllers\StringController;

if (isset($_POST['string'])) {
    echo StringController::validate($_POST['string']);
}