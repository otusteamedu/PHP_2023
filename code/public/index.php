#!/usr/bin/env php
<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Application\App;

$app = new App();
$app->run();
