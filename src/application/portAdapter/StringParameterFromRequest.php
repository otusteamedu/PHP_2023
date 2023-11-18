<?php

declare(strict_types=1);

namespace src\application\portAdapter;

use Psr\Http\Message\ServerRequestInterface as Request;

class StringParameterFromRequest implements GetValueInterface
{
    public function getValue(Request $request, string $nameParameter, $default = null)
    {
        $parsedBody = $request->getParsedBody();
        $attributes = $request->getAttributes();
        $bodyOrAttributes = empty($parsedBody) ? $attributes : $parsedBody;
        $params = $request->getQueryParams();

        $string = $this->getValueByKey($nameParameter, $bodyOrAttributes, $params, $default);
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
