<?php

namespace Radovinetch\Chat;

class Utils
{
    public function log(string $message): void
    {
        echo '[' . date('H:i:s') . '] ' . $message . PHP_EOL;
    }
}