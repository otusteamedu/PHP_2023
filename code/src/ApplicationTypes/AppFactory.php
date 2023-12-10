<?php

namespace GregoryKarman\ChatInUnixSocket\ApplicationTypes;

use GregoryKarman\ChatInUnixSocket\ApplicationTypes\Classes\AbstractApplication;
use GregoryKarman\ChatInUnixSocket\ApplicationTypes\Classes\ClientApp;
use GregoryKarman\ChatInUnixSocket\ApplicationTypes\Classes\ServerApp;

class AppFactory
{
    /**
     * @throws \Exception
     */
    public function getApplication(string $typeApplication): AbstractApplication
    {
        if ($typeApplication === 'client') {
            return new ClientApp();
        }

        if ($typeApplication === 'server') {
            return new ServerApp();
        }

        throw new \Exception('Нужно указать первым аргументом client или server');
    }
}
