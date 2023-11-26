<?php
$string = $_POST['string'] ?? null;
if (!$string) {
    badRequest();
    return;
}

while (!empty($string)) {
    $pos = strripos($string, '()');
    if ($pos === false) {
        badRequest();
        return;
    }

    $string = str_replace('()', '', $string);
}

header("{$_SERVER['SERVER_PROTOCOL']} 200 OK");
echo "Все ок";


function badRequest(): void
{
    header("{$_SERVER['SERVER_PROTOCOL']} 400 Bad Request");
    echo 'Все плохо';
}
