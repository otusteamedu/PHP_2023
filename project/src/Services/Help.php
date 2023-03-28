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
usage: php app.php [init] [help] [search [{"query"}] [{"category"}] [{price}] ]
Commands:
        help    Show this message
        init    Index creation and initial population
        search  Search with additional arguments
Additional arguments:
        query      Search query (required)
        category   Category name
        price      Maximum price value
Example:
        php app.php search "рыцори" "Исторический роман" 2000
';
    }
}
