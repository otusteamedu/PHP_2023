<?php

namespace Sva\App;

use Sva\Singleton;
use Sva\Arr;

class Config
{
    use Singleton;

    /**
     * @var array
     */
    private $config;

    protected function __construct()
    {
        if(file_exists($this->getPath())) {
            $this->config = include $this->getPath();
        }
    }

    public function get($message)
    {
        return Arr::get($this->config, $message);
    }

    protected function getPath(): string
    {
        return realpath(__DIR__ . "/../../../config/app.php");
    }
}
