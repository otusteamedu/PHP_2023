<?php

require_once "../app/BracketChecker.php";
require_once "../app/EmptyBracketSequenceException.php";

use app\BracketChecker;
use app\EmptyBracketSequenceException;
use app\Response;

try {
    $bracketChecker = new BracketChecker();
    $bracketChecker->check();
} catch (EmptyBracketSequenceException $e) {
    $response = $e->getResponse();
    $response->provideResponse();
}
