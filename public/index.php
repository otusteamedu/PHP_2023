<?php

declare(strict_types=1);

use Santonov\Otus\Application;

require_once '../vendor/autoload.php';

$app = new Application();
$result = $app->process(['123@mail-home.ru', 'manager@otus.ru', 'mail.ru']);

foreach ($result as $email => $status) {
    echo $email . ' => ' . $status . '<br>';
}
