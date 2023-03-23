<?php

namespace Sva\App;

use Sva\Singleton;

class Config
{
    use Singleton;

    /**
     * @var array
     */
    private $config;

    protected function __construct()
    {
        if (file_exists($this->getPath())) {
            $this->config = parse_ini_file($this->getPath());
        }
    }

    public function get($message)
    {
        return $this->config[$message];
    }

    protected function getPath(): string
    {
        return realpath(__DIR__ . "/../../../config/app.ini");
    }
}
