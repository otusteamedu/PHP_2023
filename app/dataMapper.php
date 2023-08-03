<?php

declare(strict_types=1);

use Root\App\dataMapper\Person;
use Root\App\dataMapper\PersonMapper;
use Root\App\enum\Sex;

require __DIR__ . '/vendor/autoload.php';

try {
    $pdo = new PDO('pgsql:host=postgresql;port=5432;dbname=db;user=user;password=password');

    $personMapper = new PersonMapper($pdo);
    $person = (new Person())
        ->setFam('family')
        ->setNam('name')
        ->setSex(Sex::F);
    echo 'Insert person', PHP_EOL;
    $personMapper->save($person);
    print_r($person);


    $person->setPrenom('prenom');
    echo 'Update person', PHP_EOL;
    $personMapper->save($person);
    print_r($person);

    echo 'Get person by id', PHP_EOL;
    $test = $personMapper->findById($person->id);
    print_r($test);

    echo 'Get all person', PHP_EOL;
    $test = $personMapper->getAll();
    echo 'Count get all: ', count($test), PHP_EOL;

    echo 'Find by fam', PHP_EOL;
    $test = $personMapper->findByFamNamOtc('family');
    echo 'Count: ', count($test), PHP_EOL;


} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage(), PHP_EOL;
}
