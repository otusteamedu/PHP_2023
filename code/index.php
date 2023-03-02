<?php

function checkBrackets($string)
{
    $counter = 0;
    for ($i = 0; $i < mb_strlen($string); $i++) {
        if ($string[$i] === '(') {
            $counter++;
        } else {
            $counter--;
        }

        if ($counter < 0) {
            return false;
        }
    }

    return $counter === 0;
}

function checkPattern($string) {
    preg_match('/[^)(]/', $string, $matches);
    return empty($matches);
}

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
