<?php

declare(strict_types=1);

namespace DEsaulenko\Hw12\Controller;

interface ControllerInterface
{
    public function add(string $json);

    public function get(string $key);

    public function deleteAll();
}
