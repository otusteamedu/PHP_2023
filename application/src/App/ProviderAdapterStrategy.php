<?php

declare(strict_types=1);

namespace Gesparo\HW\App;

use Gesparo\HW\Provider\AwesomeProvider\Manager;
use Gesparo\HW\Provider\FooProvider\FooClient;
use Gesparo\HW\Provider\SendingLogger;
use Gesparo\HW\ProviderAdapter\AwesomeProviderAdapter;
use Gesparo\HW\ProviderAdapter\FooProviderAdapter;
use Gesparo\HW\ProviderSendMessageInterface;

class ProviderAdapterStrategy
{
    private EnvManager $envManager;
    private PathHelper $pathHelper;

    public function __construct(EnvManager $envManager, PathHelper $pathHelper)
    {
        $this->envManager = $envManager;
        $this->pathHelper = $pathHelper;
    }

    /**
     * @throws AppException
     */
    public function get(): ProviderSendMessageInterface
    {
        $provider = $this->envManager->getProvider();

        switch ($provider) {
            case 'awesome':
                $logger = new SendingLogger($this->pathHelper->getLogPath() . 'awesome.log');
                $manager = new Manager($logger);
                return new AwesomeProviderAdapter($manager);
            case 'foo':
                $logger = new SendingLogger($this->pathHelper->getLogPath() . 'foo.log');
                $client = new FooClient($logger);
                return new FooProviderAdapter($client);
            default:
                throw AppException::providerNotFound($provider);
        }
    }
}
