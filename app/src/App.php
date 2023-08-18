<?php

declare(strict_types=1);

namespace Neunet\App;

use Neunet\App\Database\Database;
use Neunet\App\DataMapper\AnimalMapper;
use Neunet\App\DataMapper\HumanMapper;

class App
{
    public function run(): void
    {
        $db = (new Database())->connect();
        $animalMapper = new AnimalMapper($db);
        $humanMapper = new HumanMapper($db);

        $vasya = $animalMapper->insert([
            'type' => 'Cat',
            'male' => true,
            'name' => 'Vasya',
            'age' => 3,
            'price' => 42
        ]);

        print_r($animalMapper->findById($vasya->getId()));

        $vasya->setAge(4);
        $animalMapper->update($vasya);

        $humanMapper->insert(['name' => 'Stepa', 'phone' => '+77777777777', 'animal_id' => $vasya->getId()]);

        print_r($vasya->getOwner());
    }
}
