<?php
declare(strict_types=1);

namespace App\Component\Factory;

use App\Component\Strategy\RenderDirectoryRowBasic;
use App\Component\Strategy\RenderDirectoryRowInterface;
use App\Component\Strategy\RenderFileRowBasic;
use App\Component\Strategy\RenderFileRowInterface;

class RenderFileSystemBasic implements RenderFileSystemFactoryInterface
{

    public function createRenderDirectoryRow(): RenderDirectoryRowInterface
    {
        return new RenderDirectoryRowBasic();
    }

    public function createRenderFileRow(): RenderFileRowInterface
    {
        return new RenderFileRowBasic();
    }
}
