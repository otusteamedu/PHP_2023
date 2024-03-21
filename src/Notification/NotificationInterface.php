<?php

namespace Rabbit\Daniel\Notification;

interface NotificationInterface {
    public function send($message);
}