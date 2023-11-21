<?php

declare(strict_types=1);

use Agrechuha\Utils\UrlParser;

require_once('vendor/autoload.php');

$urlParser = new UrlParser('https://otus.ru/learning/265134/');
echo $urlParser->getHost(); // otus.ru
