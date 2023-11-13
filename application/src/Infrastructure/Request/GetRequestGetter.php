<?php

declare(strict_types=1);

namespace Gesparo\HW\Infrastructure\Request;

use Gesparo\HW\Application\UseCase\Request\ConditionDTO;
use Gesparo\HW\Application\UseCase\Request\GetEventRequest;
use Symfony\Component\HttpFoundation\Request;

class GetRequestGetter
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws \JsonException
     * @return ConditionDTO[]
     */
    public function getConditions(): GetEventRequest
    {
        $conditions = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($conditions)) {
            throw new \InvalidArgumentException('Conditions must be an array!');
        }

        if (empty($conditions)) {
            throw new \InvalidArgumentException('Conditions cannot be empty!');
        }

        $conditionObjects = [];

        foreach ($conditions as $conditionName => $conditionValue) {
            $conditionObjects[] = new ConditionDTO($conditionName, $conditionValue);
        }

        return new GetEventRequest($conditionObjects);
    }
}
