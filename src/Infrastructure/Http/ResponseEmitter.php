<?php

declare(strict_types=1);

namespace Twent\BracketsValidator\Infrastructure\Http;

use Twent\BracketsValidator\Infrastructure\Contract\ResponseEmitterContract;

final class ResponseEmitter implements ResponseEmitterContract
{
    public function __construct(
        public string $body,
        public int $code = 200,
    ) {
    }

    public static function make(string $body, int $code = 200): string
    {
        return (new ResponseEmitter($body, $code))->emit();
    }

    public function emit(): string
    {
        $this->emitCode($this->code);
        return $this->body;
    }

    public function emitCode(int $code = 200): bool|int
    {
        return http_response_code($code);
    }
}
