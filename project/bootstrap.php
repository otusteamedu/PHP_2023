<?php

declare(strict_types=1);

use Illuminate\Database\Capsule\Manager as Capsule;

chdir(dirname(__FILE__));
set_include_path(dirname(__FILE__));

require_once "vendor/autoload.php";

$capsule = new Capsule;

$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'sk_db',
    'database'  => 'balance',
    'username'  => 'root',
    'password'  => 'example',
    'charset'   => 'utf8',
    'collation' => 'utf8_unicode_ci',
    'prefix'    => '',
]);

$capsule->setAsGlobal();
$capsule->bootEloquent();
