<?php

namespace app;

class Response
{
    private int $status;
    private string $content;

    public function __construct($content, $status = 200) {
        $this->content = $content;
        $this->status = $status;
    }

    public function provideResponse(): void {
        http_response_code($this->status);
        echo $this->content;
    }
}
