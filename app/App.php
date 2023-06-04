<?php

require_once __DIR__ . '/vendor/autoload.php';

try {
    $app = new nikitaglobal\controllers\App();
    $app->run();
} catch (Exception $e) {
}
