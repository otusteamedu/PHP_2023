<?php

declare(strict_types=1);

namespace Imitronov\Hw15\Refactored\Domain\Entity;

use Imitronov\Hw15\Refactored\Domain\ValueObject\Id;
use Imitronov\Hw15\Refactored\Domain\ValueObject\NotEmptyString;
use Imitronov\Hw15\Refactored\Domain\ValueObject\Phone;

final class Client
{
    public function __construct(
        private readonly Id $id,
        private readonly NotEmptyString $name,
        private readonly Phone $phone,
    ) {
    }

    public function getId(): Id
    {
        return $this->id;
    }

    public function getName(): NotEmptyString
    {
        return $this->name;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
