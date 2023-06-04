<?php

declare(strict_types=1);

namespace Ayagudin\BrackersValid;

/**
 *Валидация строки
 */
class ValidatorString implements ValidationInterface
{
    /**
     * @var string
     */
    private string $string;
    /**
     * Статус
     * @var int
     */
    private int $status;

    /**
     * Результат
     * @var string
     */
    private string $result;

    /**
     * @param $string
     */
    public function __construct($string)
    {
        $this->string = $string;
    }

    /**
     * @return string
     */
    public function getString(): string
    {
        return $this->string;
    }


    /**
     * Валидация строки
     * @return void
     */
    public function validation(): void
    {
        $string = $this->getString();

        if (empty($string) || !preg_match('/^[()]+$/', $string)) {
            $this->setResult(Errors::EMPTY_STRING);
            $this->setStatus(400);
            return;
        }

        $bracketCount = substr_count($string, '(') == substr_count($string, ')') ? 'success': 'error';
        if($bracketCount === 'error') {
            $this->setResult(Errors::BRACKET_COUNT_ERROR);
            $this->setStatus(400);
            return;
        }

        $stack = [];
        $newStr = "";

        foreach (str_split($string) as $val) {
            if($val == "(") {
                array_push($stack, $val);
            } else {
                if(empty($stack)) {
                    break;
                } else {
                    array_pop($stack);
                }
            }
            $newStr .= $val;
        }

        $bracketCountDiff = ($newStr == $string) && empty($stack) ? 'success': 'error';
        if($bracketCountDiff === 'error') {
            $this->setResult(Errors::BRACKET_COUNT_DIFF_ERROR);
            $this->setStatus(400);
            return;
        }

        $this->setResult(Errors::BRACKET_COUNT_SUCCESS);
        $this->setStatus(200);
    }

    /**
     * Статус ошибки
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->status;
    }

    /**
     * Статус ошибки
     * @param int $status
     */
    private function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * Результат
     * @return string
     */
    public function getResult(): string
    {
        return $this->result;
    }

    /**
     * Результат
     * @param string $result
     */
    private function setResult(string $result): void
    {
        $this->result = $result;
    }

}