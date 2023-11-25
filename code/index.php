<?php

declare(strict_types=1);

require_once 'Controllers/StringValidatorController.php';

use Controllers\StringValidatorController;

try {
    $result = StringValidatorController::validate();
    echo $result;
}
catch (\mysql_xdevapi\Exception $e) {
    echo $e->getMessage("Метод недопустим");
}
