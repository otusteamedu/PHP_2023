<?php

namespace app\src;

class View
{

    function generate($template_view, $data = null)
    {
        include './views/' . $template_view;
    }
}
