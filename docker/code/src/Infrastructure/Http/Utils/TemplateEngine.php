<?php

namespace IilyukDmitryi\App\Infrastructure\Http\Utils;

class TemplateEngine
{
    public function render(string $viewFile, array $arrResult = []): string
    {
        ob_start();
        include dirname(__DIR__) . '/View/' . $viewFile;
        return ob_get_clean();
    }
}
