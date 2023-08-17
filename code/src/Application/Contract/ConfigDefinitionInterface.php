<?php

declare(strict_types=1);

namespace Art\Code\Application\Contract;

interface ConfigDefinitionInterface
{
    public function getOptions(): array;
}
