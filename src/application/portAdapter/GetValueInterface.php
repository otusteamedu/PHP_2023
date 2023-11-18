<?php

namespace src\application\portAdapter;

use Psr\Http\Message\ServerRequestInterface as Request;

interface GetValueInterface
{
    public function getValue(Request $request, string $nameParameter, $default = null);
}
