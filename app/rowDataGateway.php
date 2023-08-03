<?php

declare(strict_types=1);

use Root\App\enum\Sex;
use Root\App\rowDataGateway\PersonRowGateway;

require __DIR__ . '/vendor/autoload.php';

try {
    $pdo = new PDO('pgsql:host=postgresql;port=5432;dbname=db;user=user;password=password');
    $personGateway = new PersonRowGateway($pdo);

    $personGateway = $personGateway->setFam('family')
        ->setNam('name')
        ->setSex(Sex::F);
    $personGateway->insert();
    echo 'Insert person id =', $personGateway->id, PHP_EOL;
    print_r($personGateway);

    $personGateway->setPrenom('prenom');
    $personGateway->update();
    echo 'Update person', PHP_EOL;
    print_r($personGateway);

    echo 'Get person by id', PHP_EOL;
    $test = new PersonRowGateway($pdo, $personGateway->id);
    print_r($test);

    echo 'Get all person', PHP_EOL;
    $test = PersonRowGateway::getAll($pdo);
    echo 'Count get all: ', count($test), PHP_EOL;

    echo 'Find by fam', PHP_EOL;
    $test = PersonRowGateway::findByFamNamOtc($pdo, 'family');
    echo 'Count: ', count($test), PHP_EOL;
} catch (Exception $e) {
    echo 'Error: ' . $e->getMessage(), PHP_EOL;
}
