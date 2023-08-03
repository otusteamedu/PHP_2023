<?php

declare(strict_types=1);

use Root\App\tableGateway\PersonTableGatewayDto;
use Root\App\tableGateway\PersonTableGateway;

require __DIR__ . '/vendor/autoload.php';

try {
    $pdo = new PDO('pgsql:host=postgresql;port=5432;dbname=db;user=user;password=password');
    $personTable = new PersonTableGateway($pdo);

    $test = $personTable->getAll();
    echo 'Count get all: ', count($test), PHP_EOL;

    $test = $personTable->findByFamNamOtc('fam');
    echo 'Count find by fam: ', count($test), PHP_EOL;

    $person = (new PersonTableGatewayDto())
        ->setFam('family')
        ->setNam('name');
    echo 'Insert new person', PHP_EOL;
    $person = $personTable->insert($person);
    print_r($person);

    $person->setFam('new family');
    echo 'Update person', PHP_EOL;
    $person = $personTable->update($person);
    print_r($person);

    echo 'Get person by id', PHP_EOL;
    $test = $personTable->findById($person->id);
    print_r($test);


} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage(), PHP_EOL;
}
