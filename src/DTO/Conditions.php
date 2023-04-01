<?php

declare(strict_types=1);

namespace Twent\Hw12\DTO;

final class Conditions
{
    public function __construct(
        /** @var non-empty-string */
        private readonly string $param1,
        private readonly ?string $param2 = '',
        private readonly ?string $param3 = ''
    ) {
    }

    public function __get(string $name)
    {
        return $this->{$name};
    }
}
