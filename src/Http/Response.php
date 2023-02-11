<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Http;

final class Response
{
    public static function make($body, int $code = 200): Response
    {
        return new Response($body, $code);
    }

    public function __construct(
        public $body,
        public int $code = 200,
    ) {
        $this->run();
    }

    public function run(): void
    {
        $this->setCode($this->code);
        echo $this->body;
    }

    public function setCode(int $code = 200): bool|int
    {
        return http_response_code($code);
    }
}
