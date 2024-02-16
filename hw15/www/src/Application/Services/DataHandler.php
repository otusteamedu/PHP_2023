<?php
declare(strict_types=1);

namespace Shabanov\Otusphp\Application\Services;

use Shabanov\Otusphp\Application\Dto\DataHandlerRequest;
use Shabanov\Otusphp\Application\Dto\DataHandlerResponse;
use Shabanov\Otusphp\Domain\Collection\BookCollection;
use Shabanov\Otusphp\Domain\Repository\DataRepositoryInterface;

readonly class DataHandler
{
    public function __construct(private DataHandlerRequest $request) {}

    public function __invoke(): ?DataHandlerResponse
    {
        $bookCollection = new BookCollection($this->request->dataRepository->getData());
        return new DataHandlerResponse($bookCollection);
    }
}
