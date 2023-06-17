<?php

namespace Otus\Homework3\Service;

use Vladimirsannikov\Bracketchecker\BracketChecker;

class BracketService
{
    public function check(string $brackets) {
        $bracketChecker = new BracketChecker();
        return $bracketChecker->check($brackets);
    }
}