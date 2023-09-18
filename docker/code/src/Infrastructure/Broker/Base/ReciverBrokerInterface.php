<?php

namespace IilyukDmitryi\App\Infrastructure\Broker\Base;

use IilyukDmitryi\App\Application\Dto\MessageReciveResponse;

interface ReciverBrokerInterface
{
    public function recive(): MessageReciveResponse;
}
