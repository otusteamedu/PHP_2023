<?php

declare(strict_types=1);

namespace Vp\App\Application\Handler\Contract;

use Vp\App\Application\Exception\Contract\HandlerExceptionInterface;

interface ResultHandlerInterface
{
    public function setNext(ResultHandlerInterface $handler): ResultHandlerInterface;

    /**
     * @throws HandlerExceptionInterface
     */
    public function handle(string $result): void;
}
