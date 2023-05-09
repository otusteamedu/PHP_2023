<?php

declare(strict_types=1);

namespace Vp\App\Domain\Model;

class Node
{
    private ?int $id;
    private ?int $number;
    private int $level = 1;
    private ?string $name;
    private ?int $parentId;
    public NodeList $children;

    public function __construct(int $id = null, int $number = null, string $name = null, int $parentId = null)
    {
        $this->id = $id;
        $this->number = $number;
        $this->name = $name;
        $this->parentId = $parentId;
        $this->children = new NodeList();
    }

    public function setLevel(int $level): static
    {
        $this->level = $level;
        return $this;
    }

    public function setChildren(NodeList $children): void
    {
        $this->children = $children;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getNumber(): int
    {
        return $this->number;
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
}
