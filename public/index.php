<?php

use WorkingCode\Hw5\Application;

require_once('../vendor/autoload.php');

$application = new Application();
$validEmails = $application->run();

echo "Валидные email адреса:\n";

foreach ($validEmails as $email) {
    echo "$email\n";
}
