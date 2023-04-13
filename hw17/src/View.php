<?php

namespace Builov\Cinema;

class View
{
    public static function out($template, $map)
    {
        include $template;
    }
}
