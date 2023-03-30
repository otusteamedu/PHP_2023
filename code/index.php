<?php

declare(strict_types=1);

require 'vendor/autoload.php';

use Controllers\EmailValidationController;
use Services\EmailValidationService;
use Validators\EmailValidator;
use Validators\RequestValidator;

try {
    RequestValidator::validateRequest();

    $service = new EmailValidationService(new EmailValidator());
    $controller = new EmailValidationController($service);
    $result = $controller->validateEmails();
    header('Content-Type: application/json');
    echo json_encode(['result' => $result], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    http_response_code($e->getCode());
    echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
