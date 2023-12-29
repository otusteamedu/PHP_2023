<?php

namespace App\Application\Action;

use App\Application\Response\ResponseInterface;
use App\Infrastructure\RepositoryInterface;

interface EventActionInterface
{
    public function do(RepositoryInterface $repository): ResponseInterface;
}
