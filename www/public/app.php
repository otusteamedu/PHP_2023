<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Yalanskiy\EmailValidator\Validator;

if (isset($_POST['emails'])) {
    $out = [];
    foreach (explode(PHP_EOL, $_POST['emails']) as $email) {
        $out[] = trim($email) . ': ' . (Validator::validate($email) ? 'OK' : 'ERROR');
    }
    echo json_encode($out);
}
