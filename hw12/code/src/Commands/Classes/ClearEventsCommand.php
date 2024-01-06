<?php

namespace Gkarman\Redis\Commands\Classes;

class ClearEventsCommand extends AbstractCommand
{
    public function run(): string
    {
        $success = $this->repository->clearEvents();
        return $success ? 'true' : 'false';
    }
}
