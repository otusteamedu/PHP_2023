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
    public function run(string $email): array
    {
        $emails = explode(',', $email);
        $validatedEmails = [];
        foreach($emails as $emailItem) {
            $isValidFormat = (new CheckEmailTask())->run($emailItem);
            if($isValidFormat && (new CheckEmailDomainWithDoHTask())->run($emailItem)) {
                $validatedEmails[] = $emailItem;
            }
        }
        return $validatedEmails;
    }

}