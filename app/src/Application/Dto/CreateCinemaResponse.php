<?php

namespace YakovGulyuta\Hw15\Application\Dto;

class CreateCinemaResponse
{
    public int $code;

    public ?string $message = null;

    public ?string $error = null;

    public function __construct(int $code, ?string $message, ?string $error = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->error = $error;
    }
}
