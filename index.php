<?php

declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use App\DataMapper\EmployeeDataMapper;

$dbh = new PDO('mysql:host=localhost;dbname=test', 'root', '');

return (new EmployeeDataMapper($dbh))->findAll();
