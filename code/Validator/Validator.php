<?php
declare(strict_types=1);

namespace Validator;

use Exceptions\InvalidCountException;
use Exceptions\NotAStringException;
use Exceptions\NotClosedExcaption;

class Validator
{
    public function __construct(readonly string $string)
    {
    }

    private function validateIsString(): self
    {
        if (!is_string($this->string) || $this->string === '') {
            throw new NotAStringException('Error: Invalid input.');
        }

        return $this;
    }

    private function validateCount(): self
    {
        $open_count = substr_count($this->string, '(');
        $close_count = substr_count($this->string, ')');

        if ($open_count !== $close_count) {
            throw new InvalidCountException('Error: The number of opening and closing parentheses do not match.');
        }

        return $this;
    }

    private function checkClosed(): self
    {
        $stack = [];

        $length = mb_strlen($this->string);
        for ($i = 0; $i < $length; $i++) {
            if ($this->string[$i] === '(') {
                array_push($stack, '(');
            } elseif ($this->string[$i] === ')') {
                if (empty($stack)) {
                    throw new NotClosedExcaption('Error: The parentheses are not correctly balanced.');
                } else {
                    array_pop($stack);
                }
            }
        }

        if (!empty($stack)) {
            throw new NotClosedExcaption('Error: The parentheses are not correctly balanced.');
        }

        return $this;
    }

    /**
     * @throws InvalidCountException
     * @throws NotAStringException
     * @throws NotClosedExcaption
     */
    public function validate(): bool
    {
        $this->validateIsString()->validateCount()->checkClosed();

        return true;
    }

    public static function validatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            header('Allow: POST');
            echo 'Method Not Allowed';
            exit;
        }

        if (!isset($_POST['string'])) {
            http_response_code(422);
            echo 'There is no key string in the request';
            exit;
        }
    }
}
