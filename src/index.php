<?php
declare(strict_types=1);
const PARAM_NAME = 'string';
const OPEN = '(';
const CLOSE = ')';

$string = $_POST[PARAM_NAME] ?? null;

$errors = [];
$bracketList = mb_str_split($string);

if (0 < count($bracketList) && 0 == (count($bracketList) % 2)) {
    $openBracket = [];
    $closeBracket = [];
    foreach ($bracketList as $position => $bracket) {
        if (OPEN == $bracket) {
            $openBracket[] = $position;
        } elseif (CLOSE == $bracket) {
            $closeBracket[] = $position;
        } else {
            $errors [] = sprintf('Is don\'t valid value by key %d', $position);
        }
    }

    for ($i = 0; $i < count($openBracket); $i++) {
        $openPosition = $openBracket[$i];
        $closePosition = isset($closeBracket[$i]) ?? 0;
        if ($openPosition > $closePosition) {
            $errors[] = sprintf('Don\'t close bracket by position %d', ($openPosition + 1));
        }
    }

} else {
    $errors[] = sprintf('Don\'t valid count params', PARAM_NAME);
}


if (0 == count($errors)) {
    http_response_code(200);
} else {
    http_response_code(400);
}
