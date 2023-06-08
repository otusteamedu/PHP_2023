<?php

namespace IilyukDmitryi\App\Config;

interface ConfigProvider
{
    public function getNameClassServerWorker(): string;

    public function getNameClassClientWorker(): string;

    public function getNameClassBehaviorProvider(): string;
}
