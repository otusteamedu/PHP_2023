<?php

declare(strict_types=1);

namespace Vp\App\Application\Builder\Contract;

use Vp\App\Application\Consumer\Contract\RabbitReceiverInterface;

interface RabbitReceiverBuilderInterface
{
    public function build(): RabbitReceiverInterface;
    public function getHost(): string;
    public function getPort(): string;
    public function getUser(): string;
    public function getPassword(): string;
}
