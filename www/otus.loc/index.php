<?php

use Sherweb\ValidateEmailApp;

require_once('vendor/autoload.php');

$emailList = [
    "test@example.com",
    "invalid.email",
    "another@example.com"
];

(new ValidateEmailApp())->run($emailList);