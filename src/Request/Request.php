<?php

declare(strict_types=1);

namespace Vasilaki\Php2023\Request;
/**
 * @param string $email
 */
class Request
{

    public function __construct()
    {
    }

    public function __get(string $name)
    {
        return $_POST[$name] ?? null;
    }
}