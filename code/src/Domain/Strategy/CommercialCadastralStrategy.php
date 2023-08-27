<?php

declare(strict_types=1);

namespace Art\Php2023\Domain\Strategy;

use Art\Php2023\Domain\Contract\CadastralStrategyInterface;

class CommercialCadastralStrategy implements CadastralStrategyInterface
{
    public function getCadastralInformationByApi(): array
    {
        sleep(3);

        $this->cadastralInformation = [
            'It`s for Commercial property',
            'It`s we got an information from cadastrals api',
            'Use lazy load',
            'Some a array'
        ];

        return $this->cadastralInformation;
    }
}
