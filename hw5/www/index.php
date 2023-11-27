<?php
declare(strict_types=1);

include("vendor/autoload.php");

use Shabanov\Otus\Helper;

$arEmails = ["saveliy@mail.ru", "tratata@yandex.china123321", "alexey@niderlandy.usa", "asdasdasdasd"];
echo Helper::checkEmails($arEmails);
