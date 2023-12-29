<?php

namespace App\Application\Response;

class TheResponse implements ResponseInterface
{
    private string $response;

    public function get(): string
    {
        return $this->response;
    }

    public static function make(string $response): self
    {
        $self = new self();
        $self->setResponse($response);

        return $self;
    }

    public function setResponse(string $response): void
    {
        $this->response = $response;
    }
}
