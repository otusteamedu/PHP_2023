<?php

declare(strict_types=1);

namespace Gesparo\HW\App;

use Gesparo\HW\Factory\SMSMessageFactory;
use Gesparo\HW\Provider\QueueMessageProvider;
use Gesparo\HW\ProviderSendMessageInterface;
use Gesparo\HW\Storage\StoreInterface;

class ModeStrategy
{
    private EnvManager $envManager;
    private ProviderAdapterStrategy $providerAdapterStrategy;
    private StoreInterface $store;
    private SMSMessageFactory $factory;

    public function __construct(
        EnvManager $envManager,
        ProviderAdapterStrategy $providerAdapterStrategy,
        StoreInterface $store,
        SMSMessageFactory $factory
    ) {
        $this->envManager = $envManager;
        $this->providerAdapterStrategy = $providerAdapterStrategy;
        $this->store = $store;
        $this->factory = $factory;
    }

    /**
     * @throws AppException
     */
    public function get(): ProviderSendMessageInterface
    {
        return match ($this->envManager->getMode()) {
            'single' => $this->providerAdapterStrategy->get(),
            'queue' => new QueueMessageProvider($this->providerAdapterStrategy->get(), $this->store, $this->factory),
            default => throw AppException::modeNotFound($this->envManager->getMode()),
        };
    }
}
