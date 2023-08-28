<?php

declare(strict_types=1);

use Gesparo\Hw\App;

require "../vendor/autoload.php";

try {
    (new App())->run($argv);
} catch (Throwable $exception) {

}
