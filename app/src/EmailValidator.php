<?php

declare(strict_types=1);

namespace Imitronov\Hw5;

final class EmailValidator implements Validator
{
    private $notEmptyValidator;

    private $regExMatchValidator;

    private $dnsRecordExistsValidator;

    public function __construct()
    {
        $regEx = <<<REGEXP
        #^[a-zа-яA-ZА-Я0-9!\#$%&'*+/=?^_‘{|}~-]+(?:\.[a-zа-яA-ZА-Я0-9!\#$%&'*+/=?^_‘{|}~-]+)*@(?:[a-zа-яA-ZА-Я0-9](?:[a-zа-яA-ZА-Я0-9-]*[a-zа-яA-ZА-Я0-9])?\.)+[a-zа-яA-ZА-Я0-9](?:[a-zа-яA-ZА-Я0-9-]*[a-zа-яA-ZА-Я0-9])?$#u
REGEXP;

        $this->notEmptyValidator = new NotEmptyStringValidator();
        $this->regExMatchValidator = new RegExMatchValidator($regEx);
        $this->dnsRecordExistsValidator = new DnsRecordExistValidator('MX');
    }

    public function validate($value, $message = null): void
    {
        $this->notEmptyValidator->validate($value, $message);
        $this->regExMatchValidator->validate($value, $message ?? 'Почта указана некорректно.');

        $host = idn_to_ascii(mb_substr($value, mb_stripos($value, '@') + 1));
        $this->dnsRecordExistsValidator->validate($host, $message);
    }
}
