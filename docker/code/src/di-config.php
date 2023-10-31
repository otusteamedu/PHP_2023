<?php


use IilyukDmitryi\App\Domain\Repository\FactoryRepositoryInterface;
use IilyukDmitryi\App\Infrastructure\Storage\Mysql\FactoryRepository;

return [
    FactoryRepositoryInterface::class => DI\create(FactoryRepository::class),
   
];


