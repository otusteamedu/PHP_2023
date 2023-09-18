<?php

namespace IilyukDmitryi\App\Infrastructure\Broker\Base;

use IilyukDmitryi\App\Application\Dto\MessageSendRequest;

interface SenderBrokerInterface
{
    public function send(MessageSendRequest $messageSendRequest): void;

}
