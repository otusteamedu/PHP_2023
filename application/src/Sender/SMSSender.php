<?php

declare(strict_types=1);

namespace Gesparo\HW\Sender;

use Gesparo\HW\Factory\SMSMessageFactory;
use Gesparo\HW\ProviderSendMessageInterface;

class SMSSender
{
    private ProviderSendMessageInterface $provider;
    private SMSMessageFactory $factory;

    public function __construct(ProviderSendMessageInterface $provider, SMSMessageFactory $factory)
    {
        $this->provider = $provider;
        $this->factory = $factory;
    }

    public function sendMessage(string $phone, string $message): void
    {
        $sms = $this->factory->create($phone, $message);

        $this->provider->sendMessage([$sms]);
    }
}
