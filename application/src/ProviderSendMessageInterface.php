<?php

declare(strict_types=1);

namespace Gesparo\HW;

use Gesparo\HW\ValueObject\SMS;

interface ProviderSendMessageInterface
{
    /**
     * @param SMS[] $messages
     * @return void
     */
    public function sendMessage(array $messages): void;
}
