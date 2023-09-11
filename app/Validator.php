<?php

declare(strict_types=1);

namespace MikhailArkhipov\Php2023;

class Validator
{
    private string $string = '';
    private string $responseMessage;

    const STATUS_OK = 'HTTP/1.1 200 OK';
    const STATUS_BAD_REQUEST = 'HTTP/1.1 400 Bad Request';
    const NOT_VALID = 'Неверная строка: фигурные скобки не соединены.';
    const POST_PARAM_IS_EMPTY = 'Строка не может быть пустой!';
    const HEADER_RESPONSE = 'Invalid string: curly braces not connected.';
    const POST_PARAM_VALUE_IS_CORRECT = 'Успех!';

    public function __construct(string $str)
    {
        $this->string = trim($str);
    }

    public function validate(): string
    {
        if (empty($this->string)) {
            $this->sendHeaders(['status' => self::STATUS_BAD_REQUEST, 'response' => 'Response: ' . self::POST_PARAM_IS_EMPTY]);
            $this->responseMessage(self::POST_PARAM_IS_EMPTY);
        } else {
            $this->bracesArePaired();
        }

        return $this->responseMessage;
    }

    private function bracesArePaired(): void
    {
        if (strlen($this->removePairedBraces()) === 0) {
            $this->sendHeaders(['status' => self::STATUS_OK, 'response' => 'Response: ' . self::POST_PARAM_VALUE_IS_CORRECT]);
            $this->responseMessage(self::POST_PARAM_VALUE_IS_CORRECT);
            return;
        }

        $this->sendHeaders(['status' => self::STATUS_BAD_REQUEST, 'response' => 'Response: ' . self::HEADER_RESPONSE]);
        $this->responseMessage(self::NOT_VALID);
    }

    private function removePairedBraces()
    {
        $justBracesString = '';
        foreach (str_split($this->string) as $symbol) {
            if (in_array($symbol, ['(', ')'])) {
                $justBracesString .= $symbol;
            }
        }

        while (strpos($justBracesString, '()') !== false) {
            $justBracesString = str_replace('()', '', $justBracesString);
        }

        return $justBracesString;
    }

    private function sendHeaders(array $headers): void
    {
        foreach ($headers as $value) {
            header($value);
        }
    }

    public function responseMessage(string $message): void
    {
        $this->responseMessage = $message;
    }
}
