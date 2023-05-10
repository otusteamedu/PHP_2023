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
usage: php app.php [help] [init] [tree] [grid]

Commands:
        help    Show this message
        init    Database initialization
        tree    Output of land plots in the form of a tree
        grid    Output of land plots in the form of a grid

Example:
        php app.php help
        php app.php init
        php app.php tree
        php app.php grid
';
    }
}
