<?php

namespace Tests\PayService;

use App\Infrastructure\PayService\SomeApiPayServiceInterface;

class DummyPayServiceNegative implements SomeApiPayServiceInterface
{
    public function sendRequest(): int
    {
        return 403;
    }
}
