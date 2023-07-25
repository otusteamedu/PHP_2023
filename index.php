<?php

include_once('vendor/autoload.php');

use Qdenka\Punycode\Converter;

$decodedUrl = Converter::decode('http://xn--tda.com/');

print($decodedUrl);