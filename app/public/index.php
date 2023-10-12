<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Client;

try {
    $client = new Client();
    $client->setEmail('test@mail.ru');
    $client->setFirstName('Test1');
    $client->setMiddleName('Test2');
    $client->setLastName('Test3');
    $client->save();
    print_r(Client::getById($client->getId()));

    $client->setMiddleName("TEST456");
    $client->save();
    print_r(Client::findAll());

    $client->delete();
    print_r($client);
} catch (Exception $e) {
    print $e->getMessage();
}
