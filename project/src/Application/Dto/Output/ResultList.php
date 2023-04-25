<?php

declare(strict_types=1);

namespace Vp\App\Application\Dto\Output;

use Illuminate\Database\Eloquent\Collection;

class ResultList
{
    private Collection $result;

    public function __construct(Collection $result)
    {
        $this->result = $result;
    }

    public function getResult(): Collection
    {
        return $this->result;
    }
}
