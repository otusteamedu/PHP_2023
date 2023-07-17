<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Otus\App\App;
use Otus\App\EventProvider\RedisEventProviderFactory;

(new App())->run(new RedisEventProviderFactory());
