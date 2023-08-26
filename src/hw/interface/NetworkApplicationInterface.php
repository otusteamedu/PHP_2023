<?php

namespace Ndybnov\Hw05\hw\interface;

interface NetworkApplicationInterface
{
    public function startSocket();

    public function refreshSocket(string $command);

    public function bindSocket();

    public function setBockModeSocket();

    public function getMessage(): string;

    public function message();

    public function confirm();

    public function determineNeedToWait();

    public function stopSocket();

    public function startWaiting();

    public function isWait();
}
