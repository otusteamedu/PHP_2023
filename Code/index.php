<?php

require_once __DIR__ . '/App/App.php';
require_once __DIR__ . '/BracketsChecker/BracketsChecker.php';
require_once __DIR__ . '/Router/Router.php';

$app = new Code\App\App();
$app->run();
