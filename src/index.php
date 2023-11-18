<?php

declare(strict_types=1);

namespace src;

use Exception;
use src\application\AppDesignPatternsAPI;

require __DIR__ . '/vendor/autoload.php';


try {
    (new AppDesignPatternsAPI())->run();
} catch (Exception $e) {
    echo $e->getMessage();
}
