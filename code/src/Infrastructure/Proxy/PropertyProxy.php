<?php

declare(strict_types=1);

namespace Art\Php2023\Infrastructure\Proxy;

use Art\Php2023\Domain\Property;
use Art\Php2023\Domain\Strategy\CommercialCadastralStrategy;
use Art\Php2023\Domain\Strategy\ResidentialCadastralStrategy;
use Art\Php2023\Infrastructure\Exception\TypeNotFoundException;

class PropertyProxy extends Property
{
    private ?array $cadastralInformation = null;

    /**
     * @param int|null $id
     * @param string|null $name
     * @param string|null $type
     */
    public function __construct(?int $id = null, ?string $name = null, ?string $type = null)
    {
        parent::__construct($id, $name, $type, []);
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