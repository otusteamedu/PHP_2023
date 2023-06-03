<?php
declare(strict_types=1);

$dataEmails = $_POST['text_field'];
class Validation
{
    public static function isValidRegexp($email): bool {
        if (preg_match("/^([a-z0-9_-]+\.)*[a-z0-9_-]+@[a-z0-9_-]+(\.[a-z0-9_-]+)*\.[a-z]{2,6}$/i", $email)) {
            return true;
        } else {
            return false;
        }
    }

    public static function isValidMx($email, $record = 'MX'): bool {
        $domain = substr(strrchr($email, "@"), 1);
        return checkdnsrr($domain, $record);
    }
}

$result = [];
foreach ($dataEmails as $item) {
    if($item != "") {
        if(Validation::isValidRegexp($item) && Validation::isValidMx($item)) {
            $result[] = 'valid_email: '.$item;
        } else {
            $result[] = 'no_valid_email: '.$item;
        }
    }
}
if(count($result) > 0) {
    echo '<pre>';
    print_r($result);
    echo '</pre>';
} else {
    echo 'Email не передан!';
}




