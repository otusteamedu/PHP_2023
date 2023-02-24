<?php
declare(strict_types=1);

namespace Vp\App\Validators\Constraints;

use Symfony\Component\Validator\Constraints as Assert;

class EmailsFormConstraints
{
    public function getConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'emails' => [
                new Assert\NotBlank(null, null, null,'trim'),
                new Assert\Type('string')
            ]
        ]);
    }
}
