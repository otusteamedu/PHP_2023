<?php

declare(strict_types=1);

namespace Vp\App\Validators\Constraints;

use Symfony\Component\Validator\Constraints as Assert;

class PeriodFormConstraints
{
    public function getConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'email' => [
                new Assert\NotBlank(null, null, null, 'trim'),
                new Assert\Type('string'),
                new Assert\Email()
            ],
            'dateStart' => [
                new Assert\NotBlank(null, null, null, 'trim'),
                new Assert\Type('string'),
                new Assert\Date()
            ],
            'dateEnd' => [
                new Assert\NotBlank(null, null, null, 'trim'),
                new Assert\Type('string'),
                new Assert\Date()
            ]
        ]);
    }
}
