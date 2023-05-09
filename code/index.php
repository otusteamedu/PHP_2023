<?php

require_once "BracketChecker.php";
require_once "EmptyBracketSequenceException.php";

use app\BracketChecker;
use app\EmptyBracketSequenceException;

$string = $_REQUEST['string'] ?? null;
$bracketChecker = new BracketChecker();

try {
    $result = $bracketChecker->check($string);
}
catch (EmptyBracketSequenceException $e)
{
    echo $e->getMessage();
    exit;
}

if ($result) {
    echo 'Правильная скобочная последовательность';
}
else {
    http_response_code(400);
    echo 'Неправильная скобочная последовательность';
}
?>
