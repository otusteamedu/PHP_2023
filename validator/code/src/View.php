<?php

namespace app\src;

class View
{
    public function generate($template_view, $data = null)
    {
        include './views/' . $template_view;
    }
}
