<?php
declare(strict_types=1);

namespace Nautilus\Validator;

class Controllers
{
    private array $request;

    public function __construct(array $request)
    {
        $this->request = $request;

    }

    public function getValidatorEmail(): ValidatorEmails
    {
        return new ValidatorEmails($this->request);
    }


}