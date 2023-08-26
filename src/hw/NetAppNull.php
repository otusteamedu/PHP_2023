<?php

namespace Ndybnov\Hw05\hw;

use Ndybnov\Hw05\hw\interface\NetworkApplicationInterface;

class NetAppNull implements NetworkApplicationInterface
{
    public function getMessage(): string
    {
        return '';
    }

    public function message()
    {
        //
    }

    public function confirm()
    {
        //
    }

    public function startSocket()
    {
        // TODO: Implement startSocket() method.
    }

    public function refreshSocket(string $command)
    {
        // TODO: Implement refreshSocket() method.
    }

    public function bindSocket()
    {
        // TODO: Implement bindSocket() method.
    }

    public function setBockModeSocket()
    {
        // TODO: Implement setBockModeSocket() method.
    }

    public function determineNeedToWait()
    {
        // TODO: Implement determineNeedToWait() method.
    }

    public function stopSocket()
    {
        // TODO: Implement stopSocket() method.
    }

    public function startWaiting()
    {
        // TODO: Implement startWaiting() method.
    }

    public function isWait()
    {
        // TODO: Implement isWait() method.
    }
}
