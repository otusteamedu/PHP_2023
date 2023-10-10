<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\DataMapper\EmployeeDataMap;

$getAll = static function () {
    $dbh = new PDO('mysql:host=localhost;dbname=test', 'root', '');
    return (new EmployeeDataMap($dbh))->findAll();
};

return $getAll();
