<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\Constants;
use App\Entity\Request;
use App\Repository\RequestRepository;

readonly class UsefulActionsDemoUseCase
{
    public function __construct(private RequestRepository $requestRepository)
    {
    }

    public function doActions(Request $request): void
    {
        sleep(5);
        $request->setStatus(Constants::REQUEST_STATUS_PROCESSED);
        $this->requestRepository->save($request);
    }
}
