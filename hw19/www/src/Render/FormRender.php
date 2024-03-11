<?php

namespace Shabanov\Otusphp\Render;

class FormRender implements RenderInterface
{
    public function __construct() {}
    public function show(): string
    {
        ob_start();
        ?>
        <form method="post" action="/formHandler">
            <p>Генерация банковской выписки за указанные даты:</p>
            От <input required type="date" name="date_from" value="<?php echo date('Y-m-d'); ?>">
            По <input type="date" name="date_to" value="<?php echo date('Y-m-d'); ?>">
            <p><input type="submit" name="send" value="Запросить"></p>
        </form>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
