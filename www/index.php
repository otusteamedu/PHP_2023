<?php

declare(strict_types=1);

use Khalikovdn\Hw13\DataMapper\UserDataMapper;

require __DIR__ . '/vendor/autoload.php';

$pdo = new PDO("mysql:host=db;dbname=sitemanager", "sitemanager", "123");
$userDataMapper = new UserDataMapper($pdo);
$movie1 = $userDataMapper->findById(1);
echo "User 1: {$movie1->getName()} ({$movie1->getBirthday()})\n";

$newUserData = [
    'name' => 'Петр',
    'last_name' =>  'Петров',
    'second_name' =>  'Петрович',
    'gender' =>  'M',
    'birthday' => '12.12.1982',
];

$newUser = $userDataMapper->insert($newUserData);

echo "New User ID: {$newUser->getId()}\n";

$existingUser = $userDataMapper->findById(3);
$updatedData = [
    'name' => 'Не Петр',
    'birthday' => '12.12.1992',
];

$userDataMapper->update($existingUser, $updatedData);
echo "Updated User: {$existingUser->getName()} ({$existingUser->getBirthday()})\n";

$userToDelete = $userDataMapper->findById(4);
$userDataMapper->delete($userToDelete);
echo "User 4 deleted.\n";
