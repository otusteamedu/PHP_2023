<?php

namespace IilyukDmitryi\App\BehaviorProvider;

interface BehaviorProvider
{
    public function isServer(): bool;

    public function isClient(): bool;
}
