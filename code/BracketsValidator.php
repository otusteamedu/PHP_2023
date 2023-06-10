<?php

class BracketsValidator
{
    private array $postArray;

    public function __construct(array $postArray)
    {
        $this->postArray = $postArray;
    }

    private function isExistsString(): string
    {
        return $this->postArray['string'] ?? '';
    }

    public function validate(): bool
    {
        if ($string = $this->isExistsString()) {
            $counter = 0;
            for ($i = 0; $i < strlen($string); $i++) {
                if ($string[$i] === '(') {
                    $counter++;
                } else {
                    $counter--;
                }
                if ($counter < 0) return false;
            }

            if ($counter === 0) return true;
        }

        return false;
    }
}