<?php

declare(strict_types=1);

function getMessage(): string
{
    if (empty($_GET['string'])) {
        http_response_code(400);
        return "Empty string";
    }

    if (!checkBrackets($_GET['string'])) {
        http_response_code(400);
        return "Brackets are placed incorrectly";
    }

    if (!checkPattern($_GET['string'])) {
        http_response_code(400);
        return "String contains extra characters";
    }

    http_response_code(200);
    return "Correct!";
}
