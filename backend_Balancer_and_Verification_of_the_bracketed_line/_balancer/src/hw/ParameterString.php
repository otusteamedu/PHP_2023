<?php

namespace Ndybnov\Hw04\hw;

use Psr\Http\Message\ServerRequestInterface as Request;

class ParameterString
{
    private function __construct() {
    }

    public static function build(): self {
        return new self();
    }

    public function getValue(Request $request) {
        $parsedBody = $request->getParsedBody();
        $queryParams = $request->getQueryParams();

        $key = 'string';
        $string = $this->getValueByKey($key, $parsedBody, $queryParams, null);
        if ($string) {
            return $string;
        }

        foreach ($this->getAlternativeFieldNames() as $keyFieldName) {
            $string = $this->getValueByKey($keyFieldName, $parsedBody, $queryParams, null);
            if ($string) {
                return $string;
            }
        }

        return null;
    }

    private function getValueByKey(string $key, array|null &$data, array &$alternative, $default) {
        return $data[$key] ?? ($alternative[$key] ?? $default);
    }

    private function getAlternativeFieldNames(): array {
        return [
            'string',
            'String',
            'STRING',
            'str',
            'Str',
            'STR',
        ];
    }
}
