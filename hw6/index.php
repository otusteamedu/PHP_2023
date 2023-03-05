<?php

use Builov\Hw6\EmailValidator;

require 'vendor/autoload.php';

$ev = new EmailValidator();

$src = __DIR__ . '/test.txt';

$result = $ev->validate($src, 'file_local');
//$result = $ev->validate('https://www.php.net/manual/en/filter.examples.validation.php', 'file_remote');
//$result = $ev->validate('vnesterenko@basicdecor.ru,agorbunov@basicdecor.ru,o.furletova@basicdecor.ru', 'string');