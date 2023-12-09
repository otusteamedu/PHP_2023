<?php

declare(strict_types=1);

namespace Vasilaki\Php2023\Response;

class Response
{
    public function __construct(
        private int $code
    ) {

    }

    public function setResponseCode(): void
    {
        http_response_code($this->code);
    }
}
