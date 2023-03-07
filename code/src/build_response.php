<?php

function build_response(): void
{
    if (empty($_POST['string'])) {
        http_response_code('400');
        echo "Empty string";
        return;
    }

    if (!checkPattern($_POST['string'])) {
        http_response_code('400');
        echo "String contains extra characters";
        return;
    }

    if (!checkBrackets($_POST['string'])) {
        http_response_code('400');
        echo "Brackets are placed incorrectly";
        return;
    }

    http_response_code('200');
    echo "Ok!";
}
