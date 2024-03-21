<?php
declare(strict_types=1);

namespace Gkarman\Rabbitmq\Modules\OrderReport\Domain\ValueObject;

use InvalidArgumentException;

class Id
{
    private int $id;

    public function __construct(int $id)
    {
        $this->assertValidValue($id);
        $this->id = $id;
    }

    public function getValue(): int
    {
        return $this->id;
    }

    private function assertValidValue(int $id): void
    {
        if ($id < 0) {
            throw new InvalidArgumentException("Id не валидно");
        }
    }
}
