<?php

declare(strict_types=1);

namespace Gesparo\HW\Controller;

use Symfony\Component\HttpFoundation\Response;

interface ControllerInterface
{
    public function run(): Response;
}
