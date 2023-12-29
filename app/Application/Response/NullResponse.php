<?php

namespace App\Application\Response;

class NullResponse implements ResponseInterface
{
    public function get(): string
    {
        return '';
    }

    public static function make(): self
    {
        return new self();
    }
}
