<?php

declare(strict_types=1);

namespace Vp\App\Domain\Model;

class TreeLandPlotSh extends TreeLandPlotAbstract
{
    public function getType(): ?string
    {
        return 'SH';
    }
}
