<?php
require_once 'vendor/autoload.php';

use HW11\Elastic\DI\DependencyContainer;

$dependencyContainer = new DependencyContainer();
$product             = $dependencyContainer->createProduct();
