<?php
declare(strict_types=1);

use Nautilus\Validator\Controllers;
use Nautilus\Validator\Request;

require_once 'vendor/autoload.php';

$emails = ['test@mail.ri', 'test@mail.ru', 'test@ya.ru'];
try {
    $request = new Request($emails);
    $controller = new Controllers($request->getRequest());
    $result = $controller->getValidatorEmail();

    echo '<pre>';
    print_r($result->getResult());
    echo '</pre>';

} catch (Exception $e) {
    echo $e->getMessage('Пустой запрос');
}
