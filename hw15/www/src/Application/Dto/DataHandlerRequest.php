<?php

namespace Shabanov\Otusphp\Application\Dto;

use Shabanov\Otusphp\Domain\Repository\DataRepositoryInterface;

class DataHandlerRequest
{
    public function __construct(public DataRepositoryInterface $dataRepository) {}
}
