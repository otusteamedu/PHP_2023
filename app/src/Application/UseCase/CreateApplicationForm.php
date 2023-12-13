<?php

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreateApplicationFormRequest;
use App\Application\UseCase\Response\CreateApplicationFormResponse;
use App\Domain\Entity\ApplicationForm;
use App\Domain\Entity\Status;
use App\Domain\Repository\ApplicationFormInterface;
use App\Domain\Repository\StatusInterface;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Message;
use App\Domain\ValueObject\Name;
use Exception;

class CreateApplicationForm
{
    private ApplicationFormInterface $repositoryApplicationForm;
    private StatusInterface $repositoryStatus;

    public function __construct(ApplicationFormInterface $repositoryApplicationForm, StatusInterface $repositoryStatus)
    {
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
