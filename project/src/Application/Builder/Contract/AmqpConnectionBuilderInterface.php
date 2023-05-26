<?php

declare(strict_types=1);

namespace Vp\App\Application\Builder\Contract;

use Vp\App\Application\RabbitMq\Contract\AmqpConnectionInterface;

interface AmqpConnectionBuilderInterface
{
    public function build(): AmqpConnectionInterface;
    public function getHost(): string;
    public function getPort(): string;
    public function getUser(): string;
    public function getPassword(): string;
}
