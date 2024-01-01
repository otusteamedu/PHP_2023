<?php

namespace App\Application\UseCase;

use App\Application\Constants;
use App\Application\Dto\ConditionsDto;
use App\Application\EventGatewayInterface;
use App\Domain\Entity\Event;
use App\Domain\ValueObject\Conditions;
use App\Domain\ValueObject\Exception\ConditionsParamNameNotValidException;
use App\Domain\ValueObject\Exception\ConditionsParamValueNotValidException;
use Exception;

class GetEventUseCase
{
    public function __construct(private EventGatewayInterface $eventProvider)
    {
    }

    /**
     * @throws Exception
     */
    public function get(ConditionsDto $conditionsDto): ?Event
    {
        try {
            $conditions = new Conditions($conditionsDto->getParams());
        } catch (ConditionsParamNameNotValidException) {
            throw new Exception(Constants::CONDITIONS_PARAM_NAME_NOT_VALID);
        } catch (ConditionsParamValueNotValidException) {
            throw new Exception(Constants::CONDITIONS_PARAM_VALUE_NOT_VALID);
        }

        return $this->eventProvider->get($conditions);
    }
}
