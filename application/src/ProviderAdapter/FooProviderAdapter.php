<?php

declare(strict_types=1);

namespace Gesparo\HW\ProviderAdapter;

use Gesparo\HW\Provider\FooProvider\FooClient;
use Gesparo\HW\ProviderSendMessageInterface;
use Gesparo\HW\ValueObject\SMS;

class FooProviderAdapter implements ProviderSendMessageInterface
{
    private FooClient $fooClient;

    public function __construct(FooClient $fooClient)
    {
        $this->fooClient = $fooClient;
    }

    /**
     * @param SMS[] $messages
     * @return void
     * @throws \JsonException
     */
    public function sendMessage(array $messages): void
    {
        foreach ($messages as $message) {
            $message = $this->fooClient->getMessage(
                $message->getMessage()->getValue(),
                $message->getPhone()->getValue(),
                'now'
            );

            $message->send();
        }
    }
}
