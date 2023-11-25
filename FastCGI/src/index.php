<?php

declare(strict_types=1);

require __DIR__ . '/Validate/StringValidator.php';
require __DIR__ . '/Rout/Router.php';

use Rout\Router;
use Validate\StringValidator;

Router::route();
StringValidator::validate();
