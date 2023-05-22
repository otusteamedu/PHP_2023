<?php

declare(strict_types=1);

require '../vendor/autoload.php';

use JasFayz\BracketChecker\Bracket;

$bracket = new Bracket('()');

var_dump($bracket->checker());
