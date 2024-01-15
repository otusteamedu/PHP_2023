<?php

namespace Sherweb;

use Sherweb\Core\Request;
use Sherweb\Validate\BracketsSymbols;

class BracketValidateApp
{
    /**
     * @return bool
     */
    public function run(): bool
    {
        return Request::isPost() && BracketsSymbols::isValid($_POST["string"]);
    }
}