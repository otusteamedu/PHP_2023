<?php

declare(strict_types=1);

namespace VLebedev\BookShop;

use VLebedev\BookShop\Console\Dialog;
use VLebedev\BookShop\Exception\InputException;
use VLebedev\BookShop\Service\ElasticService\ElasticService;
use VLebedev\BookShop\Service\ElasticService\Exception\AuthenticationException;

class App
{
    private Config $config;

    public function __construct()
    {
        $this->config = new Config();
    }

    /**
     * @throws AuthenticationException
     * @throws InputException
     */
    public function execute(): void
    {
        $elasticService = new ElasticService($this->config);

        $dialog = new Dialog();
        $dialog->start($elasticService);
    }
}
