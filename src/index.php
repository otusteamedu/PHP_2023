<?php

include_once('autoload.php');

use Validators\StringBracketValidator;

$string = $_POST['string'] ?? null;

try {
    if (StringBracketValidator::process($string)->passValidation()) {
        echo "Your string: " . $string . " is valid!";
    }
} catch (Throwable $e) {
    echo "Error: " . $e->getMessage();
}
