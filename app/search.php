#!/usr/bin/env php
<?php

use App\Services\BookSearchService;
use App\Utilities\OutputHelper;

require_once 'vendor/autoload.php';
require_once 'config.php';


$opts = getopt("q:c:m:");
$params = [
    'query' => $opts['q'] ?? '',
    'category' => $opts['c'] ?? '',
    'max_price' => isset($opts['m']) ?? '',
];

$searchService = new BookSearchService();
$books = $searchService->search($params);

OutputHelper::outputTable($books);
