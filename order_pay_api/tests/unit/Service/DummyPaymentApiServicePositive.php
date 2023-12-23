<?php

declare(strict_types=1);

namespace unit\Service;

class DummyPaymentApiServicePositive implements \ApiServiceInterface
{
    public function sendRequest(array $data): int
    {
        return 200;
    }
}
