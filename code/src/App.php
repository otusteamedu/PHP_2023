<?php

declare(strict_types=1);

namespace Application;

use Application\Validator;

class App
{
    private Validator $validator;

    public function __construct()
    {
        $this->validator = new Validator();
    }

    public function run(): void
    {
        $inputString = $_POST['string'] ?? '';
        $this->validator->validate($inputString);
    }
}
