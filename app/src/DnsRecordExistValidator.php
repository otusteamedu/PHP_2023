<?php

declare(strict_types=1);

namespace Imitronov\Hw5;

use Imitronov\Hw5\Exception\DnsRecordNotExistValidationException;

final class DnsRecordExistValidator implements Validator
{
    private $type;

    public function __construct(string $type)
    {
        $this->type = $type;
    }

    public function validate($value, $message = null): void
    {
        if (!checkdnsrr($value, $this->type)) {
            throw new DnsRecordNotExistValidationException(
                sprintf('Не найдена %s-запись для %s.', $this->type, $value)
            );
        }
    }
}
