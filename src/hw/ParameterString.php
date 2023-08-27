<?php

declare(strict_types=1);

namespace Ndybnov\Hw06\hw;

use Psr\Http\Message\ServerRequestInterface as Request;

class ParameterString
{
    public function getValue(Request $request, $default = null)
    {
        $parsedBody = $request->getParsedBody();
        $queryParams = $request->getQueryParams();

        $key = 'emails';
        $string = $this->getValueByKey($key, $parsedBody, $queryParams, $default);
        if ($string) {
            return $string;
        }

        foreach ($this->getAlternativeFieldNames() as $keyFieldName) {
            $string = $this->getValueByKey($keyFieldName, $parsedBody, $queryParams, $default);
            if ($string) {
                return $string;
            }
        }

        return $default;
    }

    private function getValueByKey(string $key, array|null &$data, array &$alternative, $default)
    {
        return $data[$key] ?? ($alternative[$key] ?? $default);
    }

    private function getAlternativeFieldNames(): array
    {
        return [
            'emails',
            'Emails',
            'mails',
            'Mails',
        ];
    }
}
