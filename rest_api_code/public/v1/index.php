<?php

require __DIR__ . "/../../vendor/autoload.php";

use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Init\HttpApiInit;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\DataTransfer\ErrorResponse;

try {
    $init = new HttpApiInit();
    $init->run();
} catch (\Exception $e) {
    $init->output(
        new ErrorResponse(
            $e->getMessage()
        ),
        400
    );
} catch (\Throwable $e) {
    $init->output(
        new ErrorResponse(
            "Произошла внутренняя ошибка."
        ),
        400
    );
}
