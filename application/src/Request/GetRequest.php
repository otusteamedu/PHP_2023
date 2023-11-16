<?php

declare(strict_types=1);

namespace Gesparo\HW\Request;

use Gesparo\HW\Event\GetConditionList;
use Symfony\Component\HttpFoundation\Request;

class GetRequest
{
    private Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * @throws \JsonException
     */
    public function getConditions(): GetConditionList
    {
        $conditions = json_decode($this->request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if (!is_array($conditions)) {
            throw new \InvalidArgumentException('Conditions must be an array!');
        }

        if (empty($conditions)) {
            throw new \InvalidArgumentException('Conditions cannot be empty!');
        }

        return new GetConditionList($conditions);
    }
}
