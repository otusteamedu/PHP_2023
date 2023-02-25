<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Http;

final class Response
{
    public static function make($body, int $code = 200): string
    {
        return (new Response($body, $code))->emit();
    }

    public function __construct(
        public $body,
        public int $code = 200,
    ) {
    }

    public function emit(): string
    {
        $this->setCode($this->code);
        return $this->body;
    }

    public function setCode(int $code = 200): bool|int
    {
        return http_response_code($code);
    }
}
