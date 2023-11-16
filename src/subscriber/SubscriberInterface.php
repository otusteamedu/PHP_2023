<?php

namespace src\subscriber;

interface SubscriberInterface
{
    public function getType(): string;

    public function notify(): void;
}