<?php

require_once "../app/BracketChecker.php";
require_once "../app/EmptyBracketSequenceException.php";

use app\BracketChecker;
use app\EmptyBracketSequenceException;


try {
    $bracketChecker = new BracketChecker();
    $response = $bracketChecker->check();
    $response->provideResponse();
} catch (EmptyBracketSequenceException $e) {
    echo $e->getMessage();
}
