<?php

declare(strict_types=1);

namespace Gesparo\HW\ProviderAdapter;

use Gesparo\HW\Provider\AwesomeProvider\Manager;
use Gesparo\HW\ProviderSendMessageInterface;
use Gesparo\HW\ValueObject\SMS;

class AwesomeProviderAdapter implements ProviderSendMessageInterface
{
    private Manager $manager;

    public function __construct(Manager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * @param SMS[] $messages
     * @return void
     * @throws \JsonException
     */
    public function sendMessage(array $messages): void
    {
        foreach ($messages as $message) {
            $this->manager->send(
                $message->getMessage()->getValue(),
                $message->getPhone()->getValue(),
                0
            );
        }
    }
}
