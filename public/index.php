<?php

declare(strict_types=1);

require __DIR__ . "/../vendor/autoload.php";

use Twent\BracketsValidator\App;

session_start();

?>

<h4>Сервер: <?= "{$_SERVER['SERVER_NAME']}:{$_SERVER['SERVER_PORT']}" ?></h4>
<h4>Номер сессии: <?= session_id() ?></h4>
<h1>Результат проверки: <?= App::getValidationResult() ?></h1>
