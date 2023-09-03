<?php

declare(strict_types=1);

use App\Helpers\EmailValidator;
use App\Model\Email;
use Doctrine\Common\Collections\ArrayCollection;

require 'vendor/autoload.php';

$emailRecords = [
    'test@ya.ru',
    'teststatic@ya.ru',
    'werewr.ertr',
    '12221@123.qwe'
];

try {
    /** @var ArrayCollection<Email> $collection */
    $collection = new ArrayCollection(array_map(static function ($email) {
        return new Email((string)$email);
    }, $emailRecords));

    $validator = new EmailValidator();
    $validator->validate($collection);

    $collection->map(static function ($email) {
        echo($email . '<br />');
    });
} catch (RuntimeException $e) {
    dump($e);
}
