<?php

declare(strict_types=1);

namespace Gesparo\Hw;

use Gesparo\Hw\Client\ClientFactory;

class MainController
{
    private ArgumentRequest $request;
    private ConfigManager $configManager;

    public function __construct(ArgumentRequest $request, ConfigManager $configManager)
    {
        $this->request = $request;
        $this->configManager = $configManager;
    }

    public function index(): void
    {
        $pathToUnixFile = $this->configManager->getSetting('unix_file');
        $client = (new ClientFactory())->create($this->request->getFirstArgument(), $pathToUnixFile);

        $client->handle();
    }
}
