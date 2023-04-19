<?php

function sendErrorUser(string $message): void
{
    http_response_code(400);
    echo $message;
}

function sendSuccessResponse(string $message): void
{
    http_response_code(200);
    echo $message;
}
