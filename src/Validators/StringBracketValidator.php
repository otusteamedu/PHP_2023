<?php

namespace Validators;

use Exceptions\FirstBracketException;
use Exceptions\MismatchBracketCountException;
use Exceptions\MissingArgumentException;

class StringBracketValidator implements ValidatorContract
{
    const OPENING_BRACKET = '(';
    const CLOSING_BRACKET = ')';

    /**
     * @param string $string
     */
    public function __construct(private readonly string $string)
    {
    }

    /**
     * @param string|null $string
     * @return self
     * @throws MissingArgumentException
     */
    public static function process(?string $string): self
    {
        self::checkString($string);

        return new self($string);
    }

    /**
     * @return bool
     * @throws FirstBracketException
     * @throws MismatchBracketCountException
     */
    public function passValidation(): bool
    {
        return $this->validateBracketCount() && $this->isFirstBracketOpening();
    }

    /**
     * @return bool
     * @throws FirstBracketException
     */
    public function isFirstBracketOpening(): bool
    {
        if ($this->string[0] !== self::OPENING_BRACKET)
            throw new FirstBracketException();

        return true;
    }

    /**
     * @return bool
     * @throws MismatchBracketCountException
     */
    public function validateBracketCount(): bool
    {
        if (!$this->isBracketCountEqual())
            throw new MismatchBracketCountException();

        return true;
    }

    /**
     * @param string|null $string
     * @return void
     * @throws MissingArgumentException
     */
    private static function checkString(?string $string): void
    {
        if (empty($string))
            throw new MissingArgumentException("You must provide a string argument");
    }

    /**
     * @return bool
     */
    private function isBracketCountEqual(): bool
    {
        return $this->countBracket(self::OPENING_BRACKET) === $this->countBracket(self::CLOSING_BRACKET);
    }

    private function countBracket(string $bracket): int
    {
        return substr_count($this->string, $bracket);
    }
}