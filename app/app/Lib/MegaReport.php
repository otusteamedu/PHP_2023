<?php

declare(strict_types=1);

namespace App\Lib;

class MegaReport
{
    private array $data;

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function make(): void
    {
        dump($this->data);
        sleep(40);
    }
}
