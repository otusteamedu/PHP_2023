<?php

declare(strict_types=1);

namespace Art\Php2023\Infrastructure\Proxy;

use Art\Php2023\Domain\Property;
use Art\Php2023\Domain\Strategy\CommercialCadastralStrategy;
use Art\Php2023\Domain\Strategy\ResidentialCadastralStrategy;
use Art\Php2023\Application\Exception\TypeNotFoundException;

class PropertyProxy extends Property
{
    private ?array $cadastralInformation = null;

    /**
     * @param string $name
     * @param string $type
     */
    public function __construct(string $name, string $type)
    {
        parent::__construct($name, $type, []);
    }

    /**
     * @return array|string[]
     * @throws TypeNotFoundException
     */
    public function getCadastralInformation(): array
    {
        if ($this->cadastralInformation !== null) {
            return [];
        }

        if ($this->getType() === 'Residential') {
            return (new ResidentialCadastralStrategy())->getCadastralInformationByApi();
        }
        if ($this->getType() === 'Commercial') {
            return (new CommercialCadastralStrategy())->getCadastralInformationByApi();
        }

        return throw new TypeNotFoundException('Need pass a valid type for API');
    }
}

