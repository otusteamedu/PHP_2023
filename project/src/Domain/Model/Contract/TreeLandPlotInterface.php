<?php

namespace Vp\App\Domain\Model\Contract;

interface TreeLandPlotInterface
{
    public function getId(): int;

    public function getLevel(): int;

    public function getName(): string;

    public function getParentId(): ?int;


}
