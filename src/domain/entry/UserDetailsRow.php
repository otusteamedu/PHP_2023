<?php

namespace src\domain\entry;

class UserDetailsRow implements RowInterface
{
    private string $notify;

    public function __construct(string $notify)
    {
        $this->notify = $notify;
    }

    public function getValue(): string
    {
        return $this->notify ?? 'none';
    }
}
