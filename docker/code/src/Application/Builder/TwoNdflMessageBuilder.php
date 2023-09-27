<?php

namespace IilyukDmitryi\App\Application\Builder;

use Exception;
use IilyukDmitryi\App\Application\Dto\TwoNdflRequest;
use IilyukDmitryi\App\Application\Message\TwoNdflMessage;
use InvalidArgumentException;

class TwoNdflMessageBuilder
{
    /**
     * @throws Exception
     */
    public static function createFromRequest(TwoNdflRequest $twoNdflRequest): TwoNdflMessage
    {
        $numMonth = $twoNdflRequest->getNumMonth();
        $emailRaw = $twoNdflRequest->getEmail();

        if (is_numeric($numMonth)) {
            $numMonth = (int)$numMonth;
        } else {
            throw new InvalidArgumentException("Invalid date start");
        }

        if ($emailRaw && preg_match(
                "/^(?:[a-z0-9]+(?:[-_.]?[a-z0-9]+)?@[a-z0-9_.-]+(?:\.?[a-z0-9]+)?\.[a-z]{2,5})$/i",
                $emailRaw
            )) {
            $email = $emailRaw;
        } else {
            throw new InvalidArgumentException("Invalid email address");
        }

        $twoNdflMessage = new TwoNdflMessage();
        $twoNdflMessage->setUuid($twoNdflRequest->getUuid());
        $twoNdflMessage->setNumMonth($numMonth);
        $twoNdflMessage->setEmail($email);

        return $twoNdflMessage;
    }


}
