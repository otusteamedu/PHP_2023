<?php

require "../app/EmailChecker.php";

use app\EmailChecker;

$check = new EmailChecker();
$result = $check->process('emails.txt');

foreach ($result as $email => $status) {
    echo $email . ' - ' . $status . '<br>';
}
