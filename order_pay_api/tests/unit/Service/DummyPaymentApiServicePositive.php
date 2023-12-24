<?php

declare(strict_types=1);

namespace unit\Service;

use App\Service\PaymentApiService\ApiServiceInterface;

class DummyPaymentApiServicePositive implements ApiServiceInterface
{
    public function sendRequest(array $data): int
    {
        return 200;
    }
}
