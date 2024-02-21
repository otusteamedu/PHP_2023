<?php
declare(strict_types=1);

namespace App\Infrastructure\Repository;

use JsonException;
use Redis;
use RedisException;
use App\Domain\Entity\Event;
use App\Domain\Exception\ErrorAddInStorageException;
use App\Domain\Exception\InvalidArgumentException;
use App\Domain\Exception\NotFoundException;
use App\Domain\Repository\StorageInterface;
use App\Domain\ValueObject\Condition;
use App\Domain\ValueObject\Occasion;

class EventRedisRepository implements StorageInterface
{
    private const INDEX_NAME = 'storage:events';
    private const SIZE_PAGE  = 100;

    public function __construct(private Redis $redis)
    {
    }

    /**
     * @throws ErrorAddInStorageException
     * @throws RedisException
     */
    public function add(Event $event): void
    {
        $events = [];

        foreach ($event->getEvent() as $eventValue) {
            $events[$eventValue->getName()] = $eventValue->getValue();
        }

        $conditions = [];

        foreach ($event->getConditions() as $condition) {
            $conditions[$condition->getOperandLeft()] = $condition->getOperandRight();
        }

        $eventStr = json_encode([
            'priority'   => $event->getPriority(),
            'conditions' => $conditions,
            'event'      => $events,
        ]);

        $result = $this->redis->zAdd(static::INDEX_NAME, $event->getPriority(), $eventStr);

        if (is_bool($result)) {
            throw new ErrorAddInStorageException(sprintf(
                "%s \n%s",
                'Не удалось добавить в хранилище:',
                $eventStr
            ));
        }
    }

    /**
     * @throws RedisException
     */
    public function clearAll(): void
    {
        $this->redis->del(static::INDEX_NAME);
    }

    /**
     * @param Condition[] $conditions
     *
     * @return Event
     * @throws JsonException
     * @throws NotFoundException
     * @throws RedisException
     * @throws InvalidArgumentException
     */
    public function findOneByConditions(array $conditions): Event
    {
        $conditionList = [];

        foreach ($conditions as $condition) {
            $conditionList[$condition->getOperandLeft()] = $condition->getOperandRight();
        }

        $eventsCount = $this->redis->zCard(static::INDEX_NAME);
        $foundResult = null;

        for ($i = 0; $i < $eventsCount; $i += static::SIZE_PAGE) {
            $events = $this->redis->zRevRange(static::INDEX_NAME, $i, $i + static::SIZE_PAGE - 1);

            foreach ($events as $event) {
                $event = json_decode($event, true, flags: JSON_THROW_ON_ERROR);

                if (!array_diff_assoc($conditionList, $event['conditions'])) {
                    $foundResult = $event;

                    break 2;
                }
            }
        }

        if (!$foundResult) {
            throw new NotFoundException('Запись не найдена');
        }


        $eventsObj = [];

        foreach ( $foundResult['event'] as $name => $value) {
            $eventsObj[] = new Occasion($name, $value);
        }

        $conditionsObj = [];

        foreach ($foundResult['conditions'] as $operandLeft=>$operandRight ){
            $conditionsObj[]= new Condition($operandLeft, $operandRight);
        }

        return new Event((int)$foundResult['priority'], $conditionsObj, $eventsObj);
    }
}
