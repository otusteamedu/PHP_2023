<?php

declare(strict_types=1);

use AYamaliev\hw12\Application\Dto\EventDto;
use AYamaliev\hw12\Application\Dto\SearchDto;
use AYamaliev\hw12\Application\OutputEvent;
use AYamaliev\hw12\Infrastructure\Controllers\RedisController;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $controller = new RedisController();

    switch ($argv[1]) {
        case 'add':
            $eventDto = new EventDto($argv);
            $controller->add($eventDto);
            break;
        case 'get':
            $searchDto = new SearchDto($argv);
            $event = $controller->get($searchDto);
            ((new OutputEvent())($event));
            break;
        case 'clear':
            $controller->clear();
            break;
        case 'all':
            $events = $controller->getAll();

            foreach ($events as $event) {
                ((new OutputEvent())($event));
            }
            break;
    }

} catch (\Exception $e) {
    echo $e->getMessage();
}
