<?php

namespace Rofflexor\Hw\Tasks;

class CheckEmailTask
{
    public function run(string $email): false|int
    {
        return preg_match('/^[^()\n]*+(\((?>[^()\n]|(?1))*+\)[^()\n]*+)++$/m', $email);
    }
}