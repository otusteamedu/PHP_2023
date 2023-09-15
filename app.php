<?php
declare(strict_types = 1);

use Rofflexor\Hw\Application;

require_once 'vendor/autoload.php';

try {
    (new Application())->run($argv);
}
catch (Exception $exception) {
    throw new \RuntimeException($exception->getMessage());
}