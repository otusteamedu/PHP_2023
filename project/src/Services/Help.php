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
usage: php app.php [help] [init] [list] [get [{id}] ] [add [{login}] [{email}] ]
Commands:
        help    Show this message
        init    Database initialization
        find    Get user by id or mass getting information from a user table
        add     Add user command
Additional arguments:
        id      User id
        login   User login
        email   User email
Example:
        php app.php find
        php app.php find 4
        php app.php add username name@domain.ru
';
    }
}
