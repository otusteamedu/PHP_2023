<?php

namespace app;

use Exception;

class EmptyBracketSequenceException extends Exception
{
    private Response $response;

    public function __construct()
    {
        $this->code = 400;
        $this->message = "Пустая скобочная последовательность";
        $this->response = new Response($this->message, $this->code);
    }

    public function getResponse(): void
    {
        $this->response->provideResponse();
    }
}
