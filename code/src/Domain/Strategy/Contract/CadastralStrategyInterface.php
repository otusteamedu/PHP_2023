<?php

declare(strict_types=1);

namespace Art\Php2023\Domain\Contract;

interface CadastralStrategyInterface
{
    public function getCadastralInformationByApi(): array;
}
