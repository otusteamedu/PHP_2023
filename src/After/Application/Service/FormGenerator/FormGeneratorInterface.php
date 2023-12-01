<?php

declare(strict_types=1);

namespace App\Service\FormGenerator;

interface FormGeneratorInterface
{
    public function generate(string $date): array;
}
