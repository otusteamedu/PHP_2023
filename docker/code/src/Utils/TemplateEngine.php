<?php

namespace IilyukDmitryi\App\Utils;

class TemplateEngine
{
    public function render(string $viewFile, array $arrResult = []): string
    {
        ob_start();
        include $_SERVER['DOCUMENT_ROOT'].'/src/View/'.$viewFile;
        return ob_get_clean();
    }
}
