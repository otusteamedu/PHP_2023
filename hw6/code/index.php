<?php

use Alexgaliy\EmailValidator;

require_once 'vendor/autoload.php';
require_once 'src/templates/form.php';

try {
    $app = new EmailValidator\App();
    echo $app->validate();
} catch (Exception $e) {
    echo $e->getMessage();
}
