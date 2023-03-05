<?php

declare(strict_types=1);

namespace Imitronov\Hw5;

use Imitronov\Hw5\Exception\EmptyEmailAddressException;
use Imitronov\Hw5\Exception\EmptyMxRecordsException;
use Imitronov\Hw5\Exception\InvalidEmailAddressException;

final class EmailValidator
{
    private const REGEXP = <<<REGEXP
        #^[a-zа-я0-9!\#$%&'*+/=?^_‘{|}~-]+(?:\.[a-zа-я0-9!\#$%&'*+/=?^_‘{|}~-]+)*@(?:[a-zа-я0-9](?:[a-zа-я0-9-]*[a-zа-я0-9])?\.)+[a-zа-я0-9](?:[a-zа-я0-9-]*[a-zа-я0-9])?$#u
REGEXP;

    /**
     * @throws InvalidEmailAddressException
     * @throws EmptyEmailAddressException
     * @throws EmptyMxRecordsException
     */
    public function validate(string $emailAddress): void
    {
        if (empty(trim($emailAddress))) {
            throw new EmptyEmailAddressException();
        }

        if (!preg_match(self::REGEXP, $emailAddress)) {
            throw new InvalidEmailAddressException();
        }

        $host = mb_substr($emailAddress, mb_stripos($emailAddress, '@') + 1);

        if (!checkdnsrr(idn_to_ascii($host), 'MX')) {
            throw new EmptyMxRecordsException();
        }
    }
}
