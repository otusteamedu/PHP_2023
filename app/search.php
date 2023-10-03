#!/usr/bin/env php
<?php

use App\Services\BookSearchService;
use App\Utilities\OutputHelper;

require_once 'vendor/autoload.php';
require_once 'config.php';


$opts = getopt("", ["q:", "c:", "mp:", "minp:", "mins:", "ms:"]);

$params = [
    'query' => $opts['q'] ?? '',
    'category' => $opts['c'] ?? '',
    'mp' => $opts['mp'] ?? '',
    'minp' => $opts['minp'] ?? '',
    'mins' => $opts['mins'] ?? '',
    'ms' => $opts['ms'] ?? '',
];

$searchService = new BookSearchService();
$books = $searchService->search($params);

OutputHelper::outputTable($books);