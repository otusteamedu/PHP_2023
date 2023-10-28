<?php

require __DIR__ . "/../../vendor/autoload.php";

use VKorabelnikov\Hw20\ProcessingRestApi\Infrastructure\Init\HttpApiInit;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\DataTransfer\ErrorResponse;
use VKorabelnikov\Hw20\ProcessingRestApi\Application\Exceptions\RouteNotFoundException;

$init = new HttpApiInit();
try {
    $init->sendJsonResponseToClient(
        $init->run(),
        200
    );
} catch (RouteNotFoundException $e) {
    http_response_code(404);
} catch (\Exception $e) {
    $init->sendJsonResponseToClient(
        new ErrorResponse(
            $e->getMessage()
        ),
        400
    );
} catch (\Throwable $e) {
    $init->sendJsonResponseToClient(
        new ErrorResponse(
            "Произошла внутренняя ошибка."
        ),
        400
    );
}
