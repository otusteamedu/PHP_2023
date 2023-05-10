<?php

declare(strict_types=1);

namespace Vp\App\Application\Handler;

use Vp\App\Application\Exception\Contract\HandlerExceptionInterface;
use Vp\App\Application\Handler\Contract\ResultHandlerInterface;

abstract class AbstractResultHandler implements ResultHandlerInterface
{
    private ?ResultHandlerInterface $nextHandler;

    public function __construct(ResultHandlerInterface $nextHandler = null)
    {
        $this->nextHandler = $nextHandler;
    }

    public function setNext(ResultHandlerInterface $handler): ResultHandlerInterface
    {
        $this->nextHandler = $handler;
        return $handler;
    }

    /**
     * @throws HandlerExceptionInterface
     */
    public function handle(string $result): void
    {
        if (isset($this->nextHandler)) {
            $this->nextHandler->handle($result);
        }
    }
}
