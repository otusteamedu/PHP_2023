<?php

namespace App\Application\Helper;

class QueueHelper
{
    public function getSupports(): array
    {
        return ['rabbitmq', 'rabbit', 'redis', 'kafka'];
    }
}
