<?php

namespace Pzagainov\Balancer;

use Pzagainov\Balancer\Exception\EmptyStringException;
use Pzagainov\Balancer\Exception\InvalidStringException;

class App
{
    public function __construct(
        private readonly StringValidator $validator = new StringValidator()
    ) {
    }

    /**
     * @throws InvalidStringException
     * @throws EmptyStringException
     */
    public function run(): string
    {
        session_start();
        $string = $_POST['string'] ?? '';

        if (!$this->validator->validate($string)) {
            throw new InvalidStringException();
        }

        return 'OK';
    }
}
