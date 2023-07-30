<?php

namespace IilyukDmitryi\App\Utils;

class Helper
{
    public static function sanitize($data): string
    {
        return htmlspecialchars(trim($data));
    }

    public static function getIdFromUrl(): string
    {
        $segments = explode('/', $_SERVER['REQUEST_URI']);
        $id = $segments[count($segments) - 2] ?? '';
        return $id;
    }
}
