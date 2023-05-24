<?php

declare(strict_types=1);

namespace Vp\App\Application\Builder\Contract;

use Vp\App\Application\Producer\Contract\SenderInterface;

interface RabbitSenderBuilderInterface
{
    public function build(): SenderInterface;
    public function getHost(): string;
    public function getPort(): string;
    public function getUser(): string;
    public function getPassword(): string;
}
