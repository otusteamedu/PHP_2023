<?php

namespace IilyukDmitryi\App\Infrastructure\Http\Utils;

use IilyukDmitryi\App\Infrastructure\Config\ConfigApp;

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

    public static function getStorageName(): string
    {
        $settings = ConfigApp::get();
        $storageClassName = $settings->getNameStorage();
        $arrNames = explode('\\', $storageClassName);
        return end($arrNames);
    }
}
