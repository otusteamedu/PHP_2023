<?php

function buildResponse(): string
{
    if (empty($_POST['string'])) {
        http_response_code('400');
        return "Empty string";
    }

    if (!checkPattern($_POST['string'])) {
        http_response_code('400');
        return "String contains extra characters";
    }

    if (!checkBrackets($_POST['string'])) {
        http_response_code('400');
        return "Brackets are placed incorrectly";
    }

    http_response_code('200');
    return "Ok!";
}
