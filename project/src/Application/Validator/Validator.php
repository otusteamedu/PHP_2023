<?php

declare(strict_types=1);

namespace Vp\App\Application\Validator;

use Vp\App\Application\Exception\Contract\HandlerExceptionInterface;
use Vp\App\Application\Handler\Contract\ResultHandlerInterface;

class Validator implements Contract\ValidatorInterface
{
    private ResultHandlerInterface $resultHandler;

    public function __construct(ResultHandlerInterface $resultHandler)
    {
        $this->resultHandler = $resultHandler;
    }

    public function validate(string $result): bool
    {
        try {
            $this->resultHandler->handle($result);
        } catch (HandlerExceptionInterface $e) {
            return false;
        }
        return true;
    }
}
