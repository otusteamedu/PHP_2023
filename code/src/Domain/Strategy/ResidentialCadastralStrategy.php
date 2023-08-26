<?php

declare(strict_types=1);

namespace Art\Php2023\Domain\Strategy;

class ResidentialCadastralStrategy
{
    public function getCadastralInformationByApi(): array
    {
        sleep(4);

        $this->cadastralInformation = [
            'It`s for Residential property',
            'It`s we got an information from cadastrals api',
            'Use lazy load',
            'Some a array'
        ];

        return $this->cadastralInformation;
    }
}