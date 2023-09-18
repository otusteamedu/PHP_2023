<?php

namespace Rofflexor\Hw\Actions;

use Exception;
use Rofflexor\Hw\Tasks\CheckEmailDomainWithDoHTask;
use Rofflexor\Hw\Tasks\CheckEmailTask;

class CheckEmailAction
{
    /**
     * @throws Exception
     */
    public function run(string $email): false|int
    {
        $isValidFormat = (new CheckEmailTask())->run($email);
        if($isValidFormat) {
            return (new CheckEmailDomainWithDoHTask())->run($email);
        }
        return false;
    }

}