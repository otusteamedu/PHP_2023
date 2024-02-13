<?php

declare(strict_types=1);

use NRudakov\FirstComposerPackage\HelloProcessor;

class HelloCommand
{
    public function execute()
    {
        $helloProcessor = new HelloProcessor();
        echo $helloProcessor->getHello();
    }

}