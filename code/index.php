<?php
declare(strict_types=1);

use Nautilus\Validator\App;

require_once 'vendor/autoload.php';

$_POST['emails'] = ['22222@ya', 'test@mail.ru', 'rrrrr@mail.', 'test2@google.com'];
$app = new App();
$app->run();