<?php

namespace Nalofree\Hw5;

class Response
{
    private int $statusCode;
    private string $statusText;
    private array $headers;
    private string $body;

    public function __construct()
    {
        $this->statusCode = 200;
        $this->headers = [];
        $this->body = '';
        $this->statusText = 'OK';
    }

    public function setStatusCode($statusCode): void
    {
        $this->statusCode = (int)$statusCode;
    }

    public function setStatusText($statusText): void
    {
        $this->statusText = (string)$statusText;
    }

    public function addHeader($name, $value): void
    {
        $this->headers[$name] = $value;
    }

    public function setBody($body): void
    {
        $this->body = $body;
    }

    public function send(): void
    {
        foreach ($this->headers as $name => $value) {
            header("$name: $value");
        }

        header(sprintf('HTTP/1.1 %s %s', $this->statusCode, $this->statusText), true, $this->statusCode);
        // Просто выведем то, что в боди было
        echo $this->body;
    }
}
