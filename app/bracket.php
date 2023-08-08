<?php
require_once './vendor/autoload.php';

$bracket_string = $_POST['bracket'];

if ($bracket_string) {

    $bracket = new JasFayz\BracketChecker\Bracket($bracket_string);

    $bracket->checker() ? http_response_code(200) : http_response_code(400);

    echo $bracket->checker() ? "Скобки валидные" : "Скобки не валидные";
} else {
    echo "Поле не должно быть пустым";
}