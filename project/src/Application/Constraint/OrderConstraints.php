<?php

declare(strict_types=1);

namespace Vp\App\Application\Constraint;

use Symfony\Component\Validator\Constraints as Assert;

class OrderConstraints
{
    public function getConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'productId' => [
                new Assert\NotBlank(null, null, null, 'trim'),
                new Assert\Type('integer')
            ],
            'quantity' => [
                new Assert\NotBlank(null, null, null, 'trim'),
                new Assert\Type('integer')
            ]
        ]);
    }
}
