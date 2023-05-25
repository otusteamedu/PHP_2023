<?php

declare(strict_types=1);

namespace Iosh\EmailValidator;

trait Validator
{
    /**
     * @param string $text
     * @return Email[]
     */
    public static function extractFromText(string $text): array
    {
        $result = [];
        foreach (static::findByRegex($text) as $email) {
            $result[] = new static($email);
        }
        return $result;
    }

    private function validate(): bool
    {
        return $this->checkRegex() && $this->checkMx();
    }


    private function checkRegex(): bool
    {
        return preg_match('/^[\w-.]+@([\w-]+\.)+[\w-]{2,4}$/', $this->email);
    }

    private function checkMx(): bool
    {
        $dummy = [];
        return getmxrr(explode('@', $this->email)[1], $dummy);
    }

    private static function findByRegex($text): array
    {
        preg_match('/[\w-.]+@([\w-]+\.)+[\w-]{2,4}/', $text, $result);
        return $result;
    }
}
