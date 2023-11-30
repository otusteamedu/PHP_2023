<?php

declare(strict_types=1);

use Singurix\Emailscheck\Checker;

$checker = new Checker($_POST['emails']);
echo json_encode($checker->check());
