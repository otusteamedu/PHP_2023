<?php

namespace Shabanov\Otusphp\Render;

class Error404Render implements RenderInterface
{
    public function __construct() {}
    public function show(): string
    {
        ob_start();
        ?>
        <img src="https://www.freeparking.co.nz/learn/wp-content/uploads/2023/06/768x385-21.png">
        <p>404 Not Found</p>
        <?php
        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
