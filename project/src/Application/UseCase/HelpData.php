<?php

declare(strict_types=1);

namespace Vp\App\Application\UseCase;

use Vp\App\Application\Contract\HelpDataInterface;
use Vp\App\Application\Dto\Output\Result;

class HelpData implements HelpDataInterface
{
    public function help(): Result
    {
        return new Result(true, $this->getMessage());
    }

    private function getMessage(): string
    {
        return '
usage: php app.php [help] [console] [email]

Commands:
        help        Show this message
        console     Read queue to console
        email        Send queue by email

Example:
        php app.php help
        php app.php console
        php app.php email
';
    }
}
