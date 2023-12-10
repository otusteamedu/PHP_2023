<?php

namespace GregoryKarman\ChatInUnixSocket;

use GregoryKarman\ChatInUnixSocket\ApplicationTypes\AppFactory;

class App
{
    /**
     * @throws \Exception
     */
    public function run()
    {
        $typeOfApplication = $_SERVER['argv'][1] ?? '';
        $app = (new AppFactory())->getApplication($typeOfApplication);
        $app->run();
    }
}
