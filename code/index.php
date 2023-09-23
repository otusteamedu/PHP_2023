<?php

declare(strict_types=1);

require_once __DIR__ . '/Services/StringValidator.php';
require_once __DIR__ . '/Controllers/StringValidatorController.php';

use Controllers\StringValidatorController;

if (isset($_POST['string'])) {
    echo StringValidatorController::validate($_POST['string']);
}
