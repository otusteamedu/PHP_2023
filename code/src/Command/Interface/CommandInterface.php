<?php

declare(strict_types=1);

namespace Timerkhanov\Elastic\Command\Interface;

interface CommandInterface
{
    public function execute(): void;
}
