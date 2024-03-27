<?php
declare(strict_types=1);

namespace Shabanov\Otusphp;

use Doctrine\ORM\EntityManager;

class App
{
    public function __construct(private readonly EntityManager $entityManager)
    {}
    public function run(): void
    {
        (new Route($this->entityManager))->run();
    }
}
