<?php

declare(strict_types=1);

namespace Yevgen87\App\Services;

class ValidBrackets
{
    /**
     * @var string
     */
    private string $string;

    /**
     * @param $string
     */
    public function __construct($string)
    {
        if (!$string) {
            throw new \Exception('String must not be empty');
        }

        $this->string = preg_replace('/[^\(\)]/', '', $string);
    }

    /**
     * @return void
     */
    public function check(): void
    {
        $i = 0;

        $opened = 0;

        while ($i < strlen($this->string)) {
            if ($this->string[$i] == '(') {
                $opened++;
            }

            if ($this->string[$i] == ')') {
                $opened--;
            }

            if ($opened < 0) {
                throw new \Exception('Invalid string');
            }

            $i++;
        }

        if ($opened != 0) {
            throw new \Exception('Invalid string');
        }
    }
}
