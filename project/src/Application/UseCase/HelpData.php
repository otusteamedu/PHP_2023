<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Vp\App\Application\Contract\HelpDataInterface;
use Vp\App\Application\Dto\Output\ResultInit;

class HelpData implements HelpDataInterface
{
    public function help(): ResultInit
    {
        return new ResultInit(true, $this->getMessage());
    }

    private function getMessage(): string
    {
        return '
usage: php app.php [help] [init] [orders]

Commands:
        help        Show this message
        init        Database initialization
        orders      Starting the order queue handler

Example:
        php app.php help
        php app.php init
        php app.php orders
';
    }
}
