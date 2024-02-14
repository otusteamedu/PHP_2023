<?php

declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreateApplicationFormRequest;
use App\Application\UseCase\Response\CreateApplicationFormResponse;
use App\Domain\Entity\ApplicationForm;
use App\Domain\Entity\Status;
use App\Domain\Repository\ApplicationFormRepositoryInterface;
use App\Domain\Repository\StatusRepositoryInterface;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Message;
use App\Domain\ValueObject\Name;
use Exception;

class CreateApplicationForm
{
    private ApplicationFormRepositoryInterface $repositoryApplicationForm;
    private StatusRepositoryInterface $repositoryStatus;

    public function __construct(
        ApplicationFormRepositoryInterface $repositoryApplicationForm,
        StatusRepositoryInterface $repositoryStatus
    ) {
        $this->repositoryApplicationForm = $repositoryApplicationForm;
        $this->repositoryStatus = $repositoryStatus;
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateApplicationFormRequest $request): CreateApplicationFormResponse
    {
        $status = $this->repositoryStatus->findByName(new Name(Status::IN_WORK));
        $applicationForm = new ApplicationForm(
            new Email($request->email),
            new Message($request->message),
            $status
        );
        $this->repositoryApplicationForm->save($applicationForm);

        return new CreateApplicationFormResponse(
            $applicationForm->getId(),
            $applicationForm->getStatus()->getName()->getValue()
        );
    }
}
