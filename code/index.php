<?php

require_once "BracketChecker.php";
require_once "EmptyBracketSequenceException.php";

use app\BracketChecker;
use app\EmptyBracketSequenceException;

$bracketChecker = new BracketChecker();

try {
    $bracketChecker->check();
} catch (EmptyBracketSequenceException $e) {
    echo $e->getMessage();
}
