<?php

declare(strict_types=1);

namespace Vp\App\Services;

use Vp\App\Result\ResultHelp;

class Help
{
    public function work(): ResultHelp
    {
        return new ResultHelp($this->getMessage());
    }

    private function getMessage(): string
    {
        return '
usage: php app.php [help] [add [{priority}] [{event}] [paramName=paramValue] ... [paramName=paramValue]] [find [paramName=paramValue] ... [paramName=paramValue] ]
Commands:
        help    Show this message
        add     Adding an event to the system
        find    Event search by specified parameters
Additional arguments:
        priority                   Event priority
        event                     Event body
        paramName=paramValue      Parameter name and value
Example:
        php app.php add 1000 "My event" param1=1 param1=2
        php app.php find param1=1 param1=2
';
    }
}
