<?php

namespace src\infrastructure\log;

class Log implements LogInterface
{
    private LogInterface $log;

    public function __construct(LogInterface $log)
    {
        $this->log = $log;
    }

    public function info(string $message): void
    {
        $this->log->info($message);
    }

    public function warning(string $message): void
    {
        $this->log->warning($message);
    }

    public function error(string $message): void
    {
        $this->log->error($message);
    }
}
