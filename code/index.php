<?php
declare(strict_types=1);

require_once 'autoload.php';

use Controllers\EmailValidationController;
use Services\EmailValidationService;
use Validators\EmailValidator;
use Validators\RequestValidator;

try {
    RequestValidator::validateRequest();

    $service = new EmailValidationService(new EmailValidator());
    $controller = new EmailValidationController($service);
    $controller->validateEmails();
} catch (Exception $e) {
    http_response_code($e->getCode());
    echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
