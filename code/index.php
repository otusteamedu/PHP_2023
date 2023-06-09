<?php
declare(strict_types=1);

use Nautilus\Validator\Controllers;
use Nautilus\Validator\Request;

require_once 'vendor/autoload.php';

$emails = ['test@mail.ri', 'test@mail.ru', 'test@ya.ru'];

$request = new Request($emails);
$controller = new Controllers($request->getRequest());
$validator = $controller->getValidatorEmail();
echo $validator->getResult();