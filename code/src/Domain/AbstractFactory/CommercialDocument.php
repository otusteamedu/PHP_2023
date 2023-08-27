<?php

declare(strict_types=1);

namespace Art\Php2023\Domain\AbstractFactory;

use Art\Php2023\Domain\AbstractFactory\Contract\DocumentInterface;

class CommercialDocument implements DocumentInterface
{
    /**
     * @return void
     */
    public function getDescription(): void
    {
        echo 'I am a commercial document';
    }
}
