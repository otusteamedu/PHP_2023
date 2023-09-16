<?php

namespace Rofflexor\Hw\Actions;

use Rofflexor\Hw\Tasks\CheckEmailTask;

class CheckEmailAction
{
    public function run(string $email): false|int
    {
        return (new CheckEmailTask())->run($email);
    }

}