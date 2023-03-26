<?php

namespace Sva\App\Socket;

use Sva\App\Config;

class File
{
    private mixed $path;

    /**
     * @param $path
     */
    public function __construct($path = '')
    {
        if ($path == '') {
            $config = Config::getInstance();
            $this->path = $config->get('socket');
        } else {
            $this->path = $path;
        }
    }

    /**
     * @return mixed
     */
    public function getSocketPath(): mixed
    {
        return $this->path;
    }

    /**
     * @return void
     */
    public function deleteIfExists(): void
    {
        if (file_exists($this->path)) {
            unlink($this->path);
        }
    }
}
