<?php

namespace Vp\App\Domain\Model\Contract;

interface TreeLandPlotInterface
{
    public function setLevel(int $level): void;

    public function getId(): int;

    public function getLevel(): int;

    public function getName(): string;

    public function getParentId(): ?int;
}
