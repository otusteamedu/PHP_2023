<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Twent\BracketsValidator\Kernel;

$app = new Kernel();

$app->run();

require __DIR__ . '/../resources/partials/footer.php';
