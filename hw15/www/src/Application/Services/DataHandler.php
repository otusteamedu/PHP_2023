<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Application\Services;

use Shabanov\Otusphp\Application\Dto\DataHandlerRequest;
use Shabanov\Otusphp\Application\Dto\DataHandlerResponse;
use Shabanov\Otusphp\Domain\Repository\DataRepositoryInterface;

readonly class DataHandler
{
    public function __construct(private DataHandlerRequest $arRequest) {}

    public function __invoke(DataRepositoryInterface $dataRepository): ?DataHandlerResponse
    {
        return $this->dataRepository->findAll($this->arRequest);
    }
}
