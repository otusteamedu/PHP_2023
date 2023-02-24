<?php
declare(strict_types=1);

namespace Vp\App\Validators\Constraints;

use Symfony\Component\Validator\Constraints as Assert;

class FileFormConstraints
{
    public function getConstraints(): Assert\Collection
    {
        return new Assert\Collection([
            'file' => [
                new Assert\NotBlank(),
                new Assert\File([
                    'maxSize' => '1024k',
                    'mimeTypes' => [
                        'text/plain',
                    ],
                    'mimeTypesMessage' => 'Please upload a valid TXT',
                ])
            ]
        ]);
    }
}
