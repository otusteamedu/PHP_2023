<?php

namespace App\Infrastructure;

interface GetterInterface
{
    public function get(string $key): string;
}
