<?php
declare(strict_types=1);

use Shabanov\Otusphp\Infrastructure\App;

require '../vendor/autoload.php';

try {
    (new App())->run();
} catch(Exception $exception) {
    echo $exception->getMessage();
}
