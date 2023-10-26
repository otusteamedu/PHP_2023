<?php

declare(strict_types=1);

use Gesparo\ES\App;

require '../vendor/autoload.php';

(new App(__DIR__ . '/../', $argv))->run();