<?php
declare(strict_types=1);

namespace Elena\Hw5;

class MyRender
{
    public function render_view($viewFile, $variables=[])
    {
        $renderContent = file_get_contents($viewFile);

        foreach ($variables as $key => $value) {
            $renderContent = str_replace('{' . $key . '}', $value, $renderContent);
        }

        return $renderContent;
    }
}
