<?php

declare(strict_types=1);

use Yevgen87\App\Domain\Repositories\FilmRepositoryInterface;
use Yevgen87\App\Infrastructure\Repositories\FilmRepository;

return [
    FilmRepositoryInterface::class => \DI\autowire(FilmRepository::class)
];