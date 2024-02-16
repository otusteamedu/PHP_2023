<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Application\Dto;

use Shabanov\Otusphp\Domain\Repository\CreateRepositoryInterface;

class CreateHandlerRequest
{
    public function __construct(public CreateRepositoryInterface $createRepository) {}
}
