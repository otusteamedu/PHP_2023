<?php

declare(strict_types=1);

namespace App\Model;

class CheckEmailFileResult
{
    private array $validEmail = [];
    private array $invalidEmail = [];

    /**
     * @return array
     */
    public function getValidEmail(): array
    {
        return $this->validEmail;
    }

    /**
     * @return array
     */
    public function getInvalidEmail(): array
    {
        return $this->invalidEmail;
    }

    public function addValidEmail(string $email): void
    {
        $this->validEmail[] = $email;
    }

    public function addInvalidEmail(string $email): void
    {
        $this->invalidEmail[] = $email;
    }
}