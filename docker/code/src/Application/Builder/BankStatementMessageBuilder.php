<?php

namespace IilyukDmitryi\App\Application\Builder;

use DateTime;
use Exception;

use IilyukDmitryi\App\Application\Dto\BankStatementRequest;
use IilyukDmitryi\App\Application\Message\BankStatementMessage;

class BankStatementMessageBuilder
{
    /**
     * @throws Exception
     */
    public static function createFromRequest(BankStatementRequest $bankStatementRequest): BankStatementMessage
    {
        $uuid = $bankStatementRequest->getUuid();
        $dateStartRaw = $bankStatementRequest->getDateStart();
        $dateEndRaw = $bankStatementRequest->getDateEnd();
        $emailRaw = $bankStatementRequest->getEmail();

        if($dateStartRaw){
            $dateStart = new \DateTime($dateStartRaw);
        } else {
            throw new \InvalidArgumentException("Invalid date start");
        }

        if($dateEndRaw){
            $dateEnd = new \DateTime($dateEndRaw);
        } else {
            throw new \InvalidArgumentException("Invalid date end");
        }

        if ($emailRaw && preg_match("/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i", $emailRaw)) {
            $email = $emailRaw;
        }else{
            throw new \InvalidArgumentException("Invalid email address");
        }

        $bankStatementMessage = new BankStatementMessage();
        $bankStatementMessage->setUuid($uuid);
        $bankStatementMessage->setDateStart($dateStart);
        $bankStatementMessage->setDateEnd($dateEnd);
        $bankStatementMessage->setEmail($email);

        return $bankStatementMessage;
    }


}
