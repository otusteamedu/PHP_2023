<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use Otus\App\RequestHandler;
use Otus\App\StringValidator;

$requestHandler = new RequestHandler(
    new StringValidator(),
);

$response = $requestHandler->handle();

http_response_code($response->getHttpCode());

echo $response->getHttpContent();
