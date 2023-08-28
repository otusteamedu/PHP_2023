<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\App;

$listEmails = ['bla-bla', 'e.romanov93@yandex.ru'];

$app = new App();
print_r($app->validateEmails($listEmails));
