<?php

namespace Shabanov\Otusphp\Connect;

interface ChannelInterface
{
    public function setQueue(string $queue): self;
    public function setExchange(string $exchange): self;
    public function bindQueue(string $exchange, string $queue): self;
}
