<?php

namespace src\factory;

use src\inside\typeClass\StringClass;
use src\inside\WhichPerson;
use src\interface\NameableUserInterface;
use src\service\which\numb\class\WhoIamNumbClass;
use src\service\which\numb\PersonMatcherNumb;

class FactoryPersonNameable {
    public static function create(StringClass $roleOrName): NameableUserInterface {
        $whichPerson = (new WhichPerson())
            ->setAliasUser($roleOrName)
            ->takeAttributes();

        return (new PersonMatcherNumb(new WhoIamNumbClass()))
            ->setName($whichPerson->getName())
            ->match($whichPerson->getKey());

            //@fixme thinking how to better use
            //->setPerson($whichPerson)
            //->match();

            //->setName($whichPerson->getName())
            //->setKey($whichPerson->getKey())
            //->match();

            //->match($whichPerson);

            //(new PersonMatcherNumb($whichPerson))
            //->match();

            //(new BlaBlaWrapper($whichPerson))

            //(new PersonMatcherNumb(new WhoIamNumbClass()))
            //->match($whichPerson);
    }
}
