<?php

declare(strict_types=1);

namespace src\api;

use Psr\Http\Message\ServerRequestInterface as Request;

class StringParameterFromRequest
{
    public function getValue(Request $request, string $nameParameter, $default = null)
    {
        $parsedBody = $request->getParsedBody();
        $attributes = $request->getAttributes();
        $bodyOrAttributes = count($parsedBody) ? $parsedBody : $attributes;
        $params = $request->getQueryParams();

        $key = $nameParameter;
        $string = $this->getValueByKey($key, $bodyOrAttributes, $params, $default);
        if ($string) {
            return $string;
        }

        return $default;
    }

    private function getValueByKey(string $key, array $data, array $alternative, $default)
    {
        return $data[$key] ?? ($alternative[$key] ?? $default);
    }
}
