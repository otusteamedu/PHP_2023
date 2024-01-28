<?php

namespace Sherweb;

class Config
{
    public static function load(): array
    {
        return require_once(__DIR__ . '/../../config/.config.php');
    }
}