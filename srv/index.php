<?php

namespace App;

require_once 'EmailValidation.php';

$new = new EmailValidation();

echo $new->validateEmail('test@gmail.com');
