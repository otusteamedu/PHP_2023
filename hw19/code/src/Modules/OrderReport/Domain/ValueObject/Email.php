<?php
declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject;

use InvalidArgumentException;

class Email
{
    private string $email;

    public function __construct(string $email)
    {
        $this->assertValidValue($email);
        $this->email = $email;
    }

    public function getValue(): string
    {
        return $this->email;
    }

    private function assertValidValue(string $email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException('Поле email некорректно');
        }
    }
}
