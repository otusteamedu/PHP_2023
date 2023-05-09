<?php

declare(strict_types=1);

namespace Vp\App\Application\Dto\Output;

use Vp\App\Application\Iterator\TreeLandPlotIterator;

class ResultTree
{
    private TreeLandPlotIterator $result;

    public function __construct(TreeLandPlotIterator $result)
    {
        $this->result = $result;
    }

    public function getResult(): TreeLandPlotIterator
    {
        return $this->result;
    }
}
