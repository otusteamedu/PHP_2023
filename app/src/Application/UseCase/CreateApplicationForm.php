<?php

namespace App\Application\UseCase;

use App\Application\UseCase\Request\CreateApplicationFormRequest;
use App\Application\UseCase\Response\CreateApplicationFormResponse;
use App\Domain\Entity\ApplicationForm;
use App\Domain\Repository\ApplicationFormInterface;
use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Message;
use Exception;

class CreateApplicationForm
{
    private ApplicationFormInterface $repository;

    public function __construct(ApplicationFormInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @throws Exception
     */
    public function __invoke(CreateApplicationFormRequest $request): CreateApplicationFormResponse
    {
        $applicationForm = new ApplicationForm(new Email($request->email), new Message($request->message));
        $this->repository->save($applicationForm);

        return new CreateApplicationFormResponse($applicationForm->getId());
    }
}
