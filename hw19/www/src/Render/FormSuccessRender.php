<?php

namespace Shabanov\Otusphp\Render;

class FormSuccessRender implements RenderInterface
{
    public function __construct() {}
    public function show(): string
    {
        ob_start();
        ?>
        <p>Спасибо за вашу заявку. Скоро на email вам поступит отчет</p>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
