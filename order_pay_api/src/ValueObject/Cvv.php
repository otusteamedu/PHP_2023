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

    /**
     * @return string
     */
    public function getCvv(): string
    {
        return $this->cvv;
    }

    /**
     * @throws CvvException
     */
    private function assertCvvIsValid(string $cvv): void
    {
        if (preg_match('/^[0-9]{3}$/', $cvv) != 1) {
            throw new CvvException("'cvv' is not valid");
        }
    }
}
