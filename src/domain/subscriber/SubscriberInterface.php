<?php

namespace src\domain\subscriber;

interface SubscriberInterface
{
    public function getType(): string;

    public function notify(): void;
}
