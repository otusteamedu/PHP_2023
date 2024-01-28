<?php

namespace Gkarman\Datamaper\Dto;
class CommandDto
{
    public ?string $nameCommand;
    public function __construct(array $args)
    {
        $this->nameCommand = $args[1] ?? null;
    }
}
