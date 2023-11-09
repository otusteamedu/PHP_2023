<?php

namespace src\greeting\create;

use src\Exception\GreetingNonexistentException;
use src\Exception\IoC;
use src\greeting\fetch\Greetings;
use src\greeting\GreetingNull;
use src\inside\DataFixedArray;
use src\inside\typeClass\IntClass;
use src\interface\GreetingInterface;

class MatchGreeting {
    public static function create(IntClass $key): GreetingInterface {
        $greetings = DataFixedArray::build(); //@fixme

        $greetings->fromArray(Greetings::fetch());

        try {
            return $greetings->getByKeyOrException($key);
        } catch (GreetingNonexistentException $e) { // catch the Exception - Provider::fetch, build null pointer
            IoC::build()->matchCommand($e::class)->do($e);
            return IoCGreeting::create(GreetingNull::class);
        }
    }
}
