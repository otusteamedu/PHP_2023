<?php

use Vppavlenko\NameFaker\FakerBuilder;

require_once 'vendor/autoload.php';

$faker = FakerBuilder::create();
echo $faker->fullName . PHP_EOL;
echo $faker->fullName . PHP_EOL;
echo $faker->fullName . PHP_EOL;
