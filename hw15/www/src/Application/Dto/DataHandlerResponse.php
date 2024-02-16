<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Application\Dto;

use Shabanov\Otusphp\Domain\Collection\BookCollection;

class DataHandlerResponse
{
    public function __construct(public BookCollection $bookCollection) {}
}
