<?php

declare(strict_types=1);

namespace Ro\Php2023\Controllers;
use Symfony\Component\HttpFoundation\Response;

interface TestingControllerInterface
{
    public function ping(): Response;
}