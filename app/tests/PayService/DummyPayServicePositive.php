<?php

namespace Tests\PayService;

use App\Infrastructure\PayService\SomeApiPayServiceInterface;

class DummyPayServicePositive implements SomeApiPayServiceInterface
{
    public function sendRequest(): int
    {
        return 200;
    }
}
