<?php

namespace App\Domain\ValueObject;

use App\Domain\ValueObject\Exception\ConditionsParamNameNotValidException;
use App\Domain\ValueObject\Exception\ConditionsParamValueNotValidException;

class Conditions
{
    private const PARAM_PREFIX = 'param';

    private array $params;

    /**
     * @throws ConditionsParamValueNotValidException
     * @throws ConditionsParamNameNotValidException
     */
    public function __construct($params)
    {
        $this->validate($params);

        $this->params = $params;
    }

    public function getParams(): array
    {
        return $this->params;
    }

    /**
     * @param array<string> $params
     * @throws ConditionsParamNameNotValidException
     * @throws ConditionsParamValueNotValidException
     */
    private function validate(array $params): void
    {
        foreach ($params as $key => $value) {
            if (!str_starts_with($key, self::PARAM_PREFIX)) {
                throw new ConditionsParamNameNotValidException();
            }

            if (!is_numeric($value)) {
                throw new ConditionsParamValueNotValidException();
            }
        }
    }
}
