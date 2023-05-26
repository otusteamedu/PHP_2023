<?php

declare(strict_types=1);

namespace Dmitryesaulenko\Php2023;

use Dmitryesaulenko\Php2023\Email;

class App
{
    public function exec(): void
    {
        try {
            Response::success((new Email())->verify());
        } catch (\Exception $e) {
            Response::error($e);
        }
    }
}
