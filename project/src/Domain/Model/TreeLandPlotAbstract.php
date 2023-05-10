<?php

declare(strict_types=1);

namespace Vp\App\Domain\Model;

use Vp\App\Application\Iterator\ChildList;
use Vp\App\Domain\Model\Contract\TreeLandPlotInterface;

abstract class TreeLandPlotAbstract implements TreeLandPlotInterface
{
    private string $name;
    private int $id;
    private ?int $parentId;
    private int $level = 0;
    public ChildList $children;

    public function __construct(string $name, int $id = 0, int $parentId = null)
    {
        $this->name = $name;
        $this->id = $id;
        $this->parentId = $parentId;
        $this->children = new ChildList();
    }

    public function setLevel(int $level): void
    {
        $this->level = $level;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLevel(): int
    {
        return $this->level;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getParentId(): ?int
    {
        return $this->parentId;
    }

    abstract public function getType(): ?string;
}
