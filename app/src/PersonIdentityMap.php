<?php

declare(strict_types=1);

namespace Root\App;

use Root\App\dataMapper\Person;

class PersonIdentityMap
{
    private array $array = [];
    private static ?PersonIdentityMap $instance = null;

    private function __construct()
    {
    }

    public static function instance(): self
    {
        if (is_null(self::$instance)) {
            self::$instance = new PersonIdentityMap();
        }
        return self::$instance;
    }

    public function set(Person $person)
    {
        $this->array[$person->id] = $person;
    }
    public function get(string $id): ?Person
    {
        if (isset($this->array[$id])) {
            echo 'Return from map', PHP_EOL;
            return $this->array[$id];
        }
        return null;
    }
}
