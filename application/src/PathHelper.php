<?php

declare(strict_types=1);

namespace Gesparo\Hw;

class PathHelper
{
    private static ?self $instance = null;

    private string $root;

    private function __construct(string $root)
    {
        $this->root = $root;
    }

    public static function getInstance(): self
    {
        if(self::$instance === null) {
            self::$instance = new self($_SERVER['PWD'] . '/../');
        }

        return self::$instance;
    }

    public function getRootPath(): string
    {
        return $this->root;
    }

    public function getFilesPath(): string
    {
        return $this->getRootPath() . 'files/';
    }
}