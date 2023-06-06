<?php

use function DI\create;

return [
    \Sva\Event\Domain\EventRepositoryInterface::class => DI\factory(function () {

        $storage = \Sva\Common\App\Env::getInstance()->get('EVENT_STORAGE');
        return match ($storage) {
            'elastic' => new \Sva\Event\Infrastructure\Repositories\Elastic(),
            default => new \Sva\Event\Infrastructure\Repositories\Redis(),
        };
    }),
];
