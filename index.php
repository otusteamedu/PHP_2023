<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\DataMapper\EmployeeDataMap;

$dbh = new PDO('mysql:host=localhost;dbname=test', 'root', '');

return (new EmployeeDataMap($dbh))->findAll();
