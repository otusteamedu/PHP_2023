<?php

use Pecee\SimpleRouter\SimpleRouter;

SimpleRouter::get('/', function () {
    $content = (new \Devanych\View\Renderer('views'))->render('main');
    return $content;
});

SimpleRouter::post('/check-brackets', function () {
    $bracket_string = input()->post('bracket', null);

    if (strlen($bracket_string) === 0) {
        throw new Exception('Provide Empty string');
    }
    $bracket = new JasFayz\BracketChecker\Bracket($bracket_string);
    http_response_code($bracket->checker() ? 200 : 400);
    return $bracket->checker() ? 'Right' : 'Wrong';
});