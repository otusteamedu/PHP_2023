<?php

namespace Builov\Cinema\controller;

class Error404
{
    /**
     * @return void
     */
    public static function out(): void
    {
        http_response_code(404);
        echo 'Страница не найдена.';
    }
}
