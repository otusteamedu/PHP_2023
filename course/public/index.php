<?php

include '../vendor/autoload.php';

$searchRoot = '/var/www/html/public/test_search';
$searchName = 'test.txt';
$searchResult = [];

function searchFile($directory, $fName, &$searchResult)
{
    $activDirictory = scandir($directory);
    foreach ($activDirictory as $value) {
        $way = $directory . '/' . $value;
        if (is_dir($way) && $value != '.' && $value != '..') {
            searchFile($way, $fName, $searchResult);
        } else {
            if ($value == $fName) {
                $searchResult[] = $way;
            }
        }
    }
}

searchFile($searchRoot, $searchName, $searchResult);
$searchResult = array_filter($searchResult, function ($k) {
    return filesize($k) > 0;
});

if ($searchResult) {
    var_dump($searchResult);
} else {
    echo 'поиск не дал результатов';
}