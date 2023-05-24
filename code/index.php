<?php

include "ParenthesesStringVerificator/autoload.php";

use ParenthesesStringVerificator\App;

try {
    $obApp = new App();
    echo $obApp->run();
} catch (\Exception $obThrownException) {
    http_response_code(400);
    echo $obThrownException->getMessage();
}
