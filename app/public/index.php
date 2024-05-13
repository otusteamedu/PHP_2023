<?php

declare(strict_types=1);

use AYamaliev\Hw16\App;
use AYamaliev\Hw16\Application\Observer\ProductPublisher;
use AYamaliev\Hw16\Application\Observer\UserSubscriber;
use AYamaliev\Hw16\Domain\Entity\User;

require __DIR__ . '/../vendor/autoload.php';

try {
    $publisher = new ProductPublisher();
    $user = new User('Покупатель');
    $publisher->subscribe(new UserSubscriber($user));
    (new App($publisher))();
} catch (\Exception $e) {
    return $e->getMessage();
}
