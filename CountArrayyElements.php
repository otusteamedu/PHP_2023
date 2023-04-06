<?php

require 'vendor/autoload.php';

use ProgerWolf\PhpArrayElementsCount\ElementCounter;

$array = array (
    "fruits" ,
    "a" => "orange",
    "b" => "banana",
    "c" => "apple",
    "numbers",
    "holes" ,
    "first",
    5 => "second",
    "third",
    '212'
);

$counter = new ElementCounter();
echo $counter->countElements($array);
