<?php

declare(strict_types=1);

namespace App\ValueObject;

use App\Exception\CvvException;

class Cvv
{
    private string $cvv;

    /**
     * @throws CvvException
     */
    public function __construct(string $cvv)
    {
        $this->assertCvvIsValid($cvv);
        $this->cvv = $cvv;
    }

    public function getCvv(): string
    {
        return $this->cvv;
    }

    /**
     * @throws CvvException
     */
    private function assertCvvIsValid(string $cvv): void
    {
        if (1 != preg_match('/^[0-9]{3}$/', $cvv)) {
            throw new CvvException("'cvv' is not valid");
        }
    }
}
