<?php

namespace src\service\link;

use src\inside\DTOPerson;
use src\interface\FetchableArrayInterface;
use src\interface\LinkProviderInterface;
use src\interface\NameableUserInterface;
use src\interface\RoleUserInterface;
use src\service\linkToUserClass\ServiceWrapper;

class LinkArrayProvider implements LinkProviderInterface
{
    public function __construct(private readonly FetchableArrayInterface $service)
    {
    }

    public function getService(): FetchableArrayInterface
    {
        return $this->service;
    }

    public function get(
        RoleUserInterface $typeUser,
        DTOPerson $person
    ): NameableUserInterface
    {
        $data = (new ServiceWrapper())
            //->setFetched($this->getService()->fetch())
            ->getLink2UserClass()
            ->getLinks();
        $links = $this->getLink2NameUser($data, $person);
        return $links[$person->getKey()->toString()];
    }

    private function getLink2NameUser(array $data, DTOPerson $person): array
    {
        return array_map(
            fn($item): NameableUserInterface =>
            match (true) {
                !$this->hasItem($item) => new $item[0](),
                $this->hasItem($item)  => new $item[0]($person->getName()->toString()),
            },
            $data
        );
    }

    private function hasItem($item, string $col = 'with_name'): bool
    {
        return array_key_exists($col, $item);
    }
}
