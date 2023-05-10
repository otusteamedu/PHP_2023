<?php

declare(strict_types=1);

namespace Vp\App\Application\Dto\Output;

class ResultTree
{
    private array $result;

    public function __construct(array $result)
    {
        $this->result = $result;
    }

    public function getResult(): array
    {
        return $this->result;
    }
}
