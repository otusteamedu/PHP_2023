<?php

namespace Common\Application;

interface ConfigInterface
{
    public function get(string $key, mixed $default = null): mixed;
}