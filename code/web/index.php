<?php

require "../app/EmailChecker.php";

use app\EmailChecker;

$check = new EmailChecker();
$check->process('emails.txt');
