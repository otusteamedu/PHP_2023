<?php

namespace App\Components;

class DotEnv
{
    private array $env;

    public function __construct(string $path)
    {
        $dotEnv = new \Symfony\Component\Dotenv\Dotenv();
        $this->env = $dotEnv->parse(file_get_contents($path));
    }

    public function get(string $key): ?string
    {
        if (!array_key_exists($key, $this->env)) {
            return null;
        }

        return $this->env[$key];
    }
}
