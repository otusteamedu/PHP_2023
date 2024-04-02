<?php

declare(strict_types=1);

use AYamaliev\hw13\Application\Db\Connection;
use AYamaliev\hw13\Application\Dto\NewsDto;
use AYamaliev\hw13\Infrastructure\NewsController;

require __DIR__ . '/../vendor/autoload.php';

try {
    $connection = Connection::get()->connect();
    $controller = new NewsController($connection);

    switch ($argv[1]) {
        case 'all':
            $result = $controller->getAll();
            break;
        case 'get':
            $result = $controller->getById((int)$argv[2]);
            break;
        case 'delete':
            $result = $controller->deleteById((int)$argv[2]);
            break;
        case 'add':
            $newsDto = new NewsDto($argv);
            $result = $controller->add($newsDto);
            break;
        default:
            $result = 'Use `php public/index.php [all|get 1|delete 1|add --title=title --text=text --image=path-to-image --created_at=2024-04-12]`';
    }

    print_r($result);
} catch (\Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
