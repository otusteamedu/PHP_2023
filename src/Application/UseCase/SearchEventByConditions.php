<?php
declare(strict_types=1);

namespace App\Application\UseCase;

use App\Application\DTO\Builder\EventDTOBuilder;
use App\Application\DTO\ConditionDTO;
use App\Application\DTO\EventDTO;
use App\Domain\Exception\InvalidArgumentException;
use App\Domain\Repository\StorageInterface;
use App\Domain\ValueObject\Condition;

readonly class SearchEventByConditions implements SearchEventInterface
{
    public function __construct(
        private StorageInterface $storage,
        private EventDTOBuilder  $eventDTOBuilder,
    ) {
    }

    /**
     * @param ConditionDTO[] $conditionsDTO
     *
     * @throws InvalidArgumentException
     */
    public function searchBy(array $conditionsDTO): EventDTO
    {
        $conditions = array_map(
            static fn (ConditionDTO $conditionDTO): Condition => new Condition(
                $conditionDTO->getOperandLeft(), $conditionDTO->getOperandRight()
            ),
            $conditionsDTO
        );
        $event      = $this->storage->findOneByConditions($conditions);

        return $this->eventDTOBuilder->buildFromEntity($event);
    }
}
