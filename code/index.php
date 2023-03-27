<?php
declare(strict_types=1);

use code\Controllers\EmailValidationController\EmailValidationController;
use code\Services\EmailValidationService\EmailValidationService;
use code\Validator\RequestValidator;

require_once 'autoload.php';

try {
    // Validate the request
    RequestValidator::validateRequest();

    // Initialize the EmailValidationController with the EmailValidationService
    $service = new EmailValidationService();
    $controller = new EmailValidationController($service);

    // Decode the input and validate the emails
    $input = json_decode(file_get_contents('php://input'), true);
    $result = $controller->validateEmails($input['emails'] ?? []);

    // Output the result as JSON
    header('Content-Type: application/json');
    echo json_encode(['result' => $result], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
} catch (Exception $e) {
    // Output any errors as JSON
    http_response_code($e->getCode());
    echo json_encode(['error' => $e->getMessage()], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
}
