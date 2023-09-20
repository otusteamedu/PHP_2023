<?php

declare(strict_types=1);

namespace Art\Code\Infrastructure\View;

class View
{
    /**
     * Render view
     * @param string $view
     * @param array $data
     * @return void
     */
    public static function render(string $view, array $data = [])
    {
        extract($data, EXTR_OVERWRITE);

        require_once("/data/mysite.local/src/views/{$view}.php");

        exit();
    }

    /**
     * Render into string
     * @param string $view
     * @param array $data
     * @return string
     */
    public static function renderStr(string $view, array $data = []): string
    {
        extract($data, EXTR_OVERWRITE);

        ob_start();
        require_once("/data/mysite.local/src/Application/Views/{$view}.php");
        $str = ob_get_contents();
        ob_end_clean();

        return $str;
    }
}