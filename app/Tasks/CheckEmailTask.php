<?php

namespace Rofflexor\Hw\Tasks;

class CheckEmailTask
{
    public function run(string $email): false|int
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}