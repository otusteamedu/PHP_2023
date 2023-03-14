<?php

declare(strict_types=1);

function getMessage(): string
{
    if (empty($_GET['string'])) {
       return generateResponse(400,'Empty string');
    }

    if (!checkBrackets($_GET['string'])) {
       return generateResponse(400,'Brackets are placed incorrectly');
    }

    if (!checkPattern($_GET['string'])) {
        return generateResponse(400,'String contains extra characters');
    }

    http_response_code(200);
    return "Correct!";
}
