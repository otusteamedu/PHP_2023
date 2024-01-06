<?php

namespace Gkarman\Redis\Dto;

class CommandDto
{
    public ?string $nameCommand;
    public ?int $param1;
    public ?int $param2;

    public function __construct(array $args)
    {
        $this->nameCommand = $args[1] ?? null;
        $this->param1 = $args[2] ?? null;
        $this->param2 = $args[3] ?? null;
    }
}
