<?php

declare(strict_types=1);

namespace unit\Service;

use App\Service\PaymentApiService\ApiServiceInterface;

class DummyPaymentApiServiceNegative implements ApiServiceInterface
{
    public function sendRequest(array $data): int
    {
        return 403;
    }
}
