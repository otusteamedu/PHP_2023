<?php

declare(strict_types=1);

use Singurix\Checkinput\Input;

$checker = new Input($_POST);
echo $checker->check();
