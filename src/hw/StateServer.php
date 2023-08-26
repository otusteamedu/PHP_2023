<?php

namespace Ndybnov\Hw05\hw;

class StateServer
{
    private int $state;

    public function setWait(): void
    {
        $this->state = 0;
    }

    public function setStop(): void
    {
        $this->state = 1;
    }

    public function isWaiting(): bool
    {
        return (0 === $this->state);
    }
}
