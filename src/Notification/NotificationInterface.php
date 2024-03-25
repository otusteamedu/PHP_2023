<?php

namespace Rabbit\Daniel\Notification;

interface NotificationInterface
{
    public function send(string $to, string $message, array $options = []);
}