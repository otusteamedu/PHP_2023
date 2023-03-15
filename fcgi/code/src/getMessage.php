<?php

declare(strict_types=1);

function getMessage(): string
{
    if (isset($_POST['string'])) {
        generateResponse(400, "Empty string");
    }

    if (!checkBrackets($_POST['string'])) {
        generateResponse(400, "Brackets are placed incorrectly");
    }

    if (!checkPattern($_POST['string'])) {
        generateResponse(400, "String contains extra characters");
    }

    http_response_code(200);
    return "Correct!";
}
