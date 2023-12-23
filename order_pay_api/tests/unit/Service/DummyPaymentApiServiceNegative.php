<?php

declare(strict_types=1);

namespace unit\Service;

class DummyPaymentApiServiceNegative implements \ApiServiceInterface
{

    public function sendRequest(array $data): int
    {
        return 403;
    }
}
