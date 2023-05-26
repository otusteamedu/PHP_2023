<?php

declare(strict_types=1);

namespace Vp\App\Infrastructure\Console\Commands;

use Vp\App\Application\Contract\EmailDataInterface;
use Vp\App\Infrastructure\Console\Contract\CommandInterface;

class CommandEmail implements CommandInterface
{
    private EmailDataInterface $emailData;

    public function __construct(EmailDataInterface $emailData)
    {
        $this->emailData = $emailData;
    }

    public function run(): void
    {
        $this->emailData->work();
    }
}
