<?php

declare(strict_types=1);

namespace Rout;

class Router
{
    public static function route(): void
    {
        if ($_SERVER['REQUEST_URI'] === '/form') {
            require "View/form.html";
            exit();
        }
    }
}
