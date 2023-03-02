<?php

declare(strict_types=1);

namespace Imitronov\Hw4\Http;

use Imitronov\Hw4\View\View;

final class Response
{
    public function __construct(View $view, int $code = 200)
    {
        http_response_code($code);
        $view->output();
    }
}
