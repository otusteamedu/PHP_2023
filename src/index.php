<?php

declare(strict_types=1);

use Otus\App\Core\App;
use Otus\App\Parenthesis\ParenthesisValidator;
use Otus\App\Parenthesis\RequestHandler;

require_once __DIR__ . '/../vendor/autoload.php';

$kernel = new App(
    new RequestHandler(new ParenthesisValidator()),
);
$kernel->run();
