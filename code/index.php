<?php
declare(strict_types=1);

use code\Validator\EmailValidator;

require_once 'autoload.php';
require_once 'EmailValidator.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    exit('Method not allowed');
}

$input = json_decode(file_get_contents('php://input'), true);

if (!isset($input['emails']) || !is_array($input['emails'])) {
    http_response_code(400);
    exit('Invalid input');
}

$validator = new EmailValidator();
$result = $validator->validate($input['emails']);

header('Content-Type: application/json');
echo json_encode($result);