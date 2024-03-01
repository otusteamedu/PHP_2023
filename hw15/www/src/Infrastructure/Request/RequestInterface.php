<?php

namespace Shabanov\Otusphp\Infrastructure\Request;

interface RequestInterface
{
    public function process(): array;
}
