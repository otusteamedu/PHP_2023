<?php

namespace app;

class Validator
{
    private array $postArray;
    private string $string;
    private string $headerStatus;
    private string $headerResponse;
    private string $responseMessage;

    public function __construct(array $postRequestArray)
    {
        $this->postArray = $postRequestArray;
    }

    public function validate(string $postParamName)
    {
        if ($this->postParamExist($postParamName)) {
            if (! $this->stringIsEmpty()) {
                $this->bracesArePaired();
            }
        }

        return [
            'header_status' => $this->headerStatus,
            'header_response' => 'Response: ' . $this->headerResponse,
            'response_message' => $this->responseMessage,
        ];
    }

    private function postParamExist(string $postParamName)
    {
        if (isset($this->postArray[$postParamName])) {
            $this->string = $this->postArray[$postParamName];
            return true;
        }

        $this->prepareResponse(Response::STATUS_BAD_REQUEST, Response::POST_PARAM_IS_MISSING);
        return false;
    }

    private function stringIsEmpty()
    {
        if (! empty($this->string)) {
            return false;
        }

        $this->prepareResponse(Response::STATUS_BAD_REQUEST, Response::POST_PARAM_IS_EMPTY);
        return true;
    }

    private function bracesArePaired()
    {
        if ($this->removePairedBraces()) {
            $this->prepareResponse(Response::STATUS_OK, Response::POST_PARAM_VALUE_IS_CORRECT);
            return true;
        }

        $this->prepareResponse(Response::STATUS_BAD_REQUEST, Response::POST_PARAM_VALUE_IS_NOT_VALID);
        return false;
    }

    private function removePairedBraces()
    {
        $countLeftBraces = 0;
        $result = true;
        foreach (str_split($this->string) as $symbol) {
            if (in_array($symbol, ['('])) {
                $countLeftBraces++;
            }
        }

        if ($countLeftBraces != substr_count($this->string, ')')) {
            $result = false;
        }

        return $result;
    }

    private function prepareResponse(string $headerStatus, string $responseMessage)
    {
        $this->headerStatus = $headerStatus;
        $this->headerResponse = $responseMessage;
        $this->responseMessage = $responseMessage;
    }
}
