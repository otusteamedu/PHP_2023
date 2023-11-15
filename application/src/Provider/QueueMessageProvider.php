<?php

declare(strict_types=1);

namespace Gesparo\HW\Provider;

use Gesparo\HW\Factory\SMSMessageFactory;
use Gesparo\HW\ProviderSendMessageInterface;
use Gesparo\HW\Storage\StoreInterface;
use Gesparo\HW\Storage\ValueObject\StoreElement;
use Gesparo\HW\ValueObject\SMS;

class QueueMessageProvider implements ProviderSendMessageInterface
{
    private const CACHED_LIMIT = 10;

    private ProviderSendMessageInterface $provider;
    private StoreInterface $store;
    private SMSMessageFactory $factory;

    public function __construct(ProviderSendMessageInterface $provider, StoreInterface $store, SMSMessageFactory $factory)
    {
        $this->provider = $provider;
        $this->store = $store;
        $this->factory = $factory;
    }

    /**
     * @param SMS[] $messages
     * @return void
     */
    public function sendMessage(array $messages): void
    {
        foreach ($messages as $message) {
            $this->store->save($message->getPhone()->getValue(), $message->getMessage()->getValue());

            /** @noinspection DisconnectedForeachInstructionInspection */
            if ($this->store->count() >= self::CACHED_LIMIT) {
                $this->sendMessageToProvider($this->store->getAll());

                $this->store->clear();
            }
        }
    }

    /**
     * @param StoreElement[] $storedData
     * @return void
     */
    private function sendMessageToProvider(array $storedData): void
    {
        $result = [];

        foreach ($storedData as $storeElement) {
            $result[] = $this->factory->create($storeElement->getPhone(), $storeElement->getMessage());
        }

        $this->provider->sendMessage($result);
    }
}
