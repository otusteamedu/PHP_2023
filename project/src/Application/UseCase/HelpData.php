<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Vp\App\Application\Contract\HelpDataInterface;
use Vp\App\Application\Dto\Output\ResultHelp;

class HelpData implements HelpDataInterface
{
    public function help(): ResultHelp
    {
        return new ResultHelp(true, $this->getMessage());
    }

    private function getMessage(): string
    {
        return '
usage: php app.php [help] [console] [smtp]

Commands:
        help        Show this message
        console     Read queue to console
        smtp        Send queue by email

Example:
        php app.php help
        php app.php console
        php app.php smtp
';
    }
}
