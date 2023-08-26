<?php

declare(strict_types=1);

namespace app;

class Validator
{
    private array $postArray;
    private string $string = '';
    private string $headerStatus;
    private string $headerResponse;
    private string $responseMessage;

    const STATUS_OK = 'HTTP/1.1 200 OK';
    const STATUS_BAD_REQUEST = 'HTTP/1.1 400 Bad Request';
    const POST_PARAM_IS_MISSING = 'Parameter "string" is missing.';
    const POST_PARAM_IS_EMPTY = 'Строка не может быть пустой!';
    const POST_PARAM_VALUE_IS_NOT_VALID = 'Неверная строка: фигурные скобки не соединены.';
    const POST_PARAM_VALUE_IS_CORRECT = 'Успех!';

    public function __construct(array $postRequestArray)
    {
        $this->postArray = $postRequestArray;
    }

    public function validate(string $postParamName): array
    {
        if ($this->postParamExist($postParamName)) {
            if (!$this->stringIsEmpty()) {
                $this->bracesArePaired();
            }
        }

        return [
            'header_status' => $this->headerStatus,
            'header_response' => 'Response: ' . $this->headerResponse,
            'response_message' => $this->responseMessage,
        ];
    }

    private function postParamExist(string $postParamName): bool
    {
        if (isset($this->postArray[$postParamName])) {
            $this->string = $this->postArray[$postParamName];
            return true;
        }

        $this->prepareResponse(self::STATUS_BAD_REQUEST, self::POST_PARAM_IS_MISSING);
        return false;
    }

    private function stringIsEmpty(): bool
    {
        if (!empty($this->string)) {
            return false;
        }

        $this->prepareResponse(self::STATUS_BAD_REQUEST, self::POST_PARAM_IS_EMPTY);
        return true;
    }

    private function bracesArePaired(): void
    {
        if (strlen($this->removePairedBraces()) === 0) {
            $this->prepareResponse(self::STATUS_OK, self::POST_PARAM_VALUE_IS_CORRECT);
            return;
        }

        $this->prepareResponse(self::STATUS_BAD_REQUEST, self::POST_PARAM_VALUE_IS_NOT_VALID);
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

    private function prepareResponse(string $headerStatus, string $responseMessage)
    {
        $this->headerStatus = $headerStatus;
        $this->headerResponse = $responseMessage;
        $this->responseMessage = $responseMessage;
    }
}
