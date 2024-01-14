<?php
require './vendor/autoload.php';

use \Shabanov\Otusphp\App;

try {
    (new App())->run();
} catch (\Exception $e) {
    throw new \Exception($e->getMessage());
}
