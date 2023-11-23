<?php
declare(strict_types=1);

require(__DIR__ . '/vendor/autoload.php');

use VyacheslavShabanov\Parsing\Search\Site;

echo (new Site('штаны'))->run();
