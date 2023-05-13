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
        $this->response = new Response($this->code, $this->message);
    }

    public function getResponse(): Response
    {
        return $this->response;
    }
}
