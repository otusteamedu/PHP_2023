<?php
declare(strict_types=1);

namespace WorkingCode\Hw12\Service;

use JsonException;
use Redis;
use RedisException;
use WorkingCode\Hw12\DTO\Builder\EventDTOBuilder;
use WorkingCode\Hw12\DTO\EventDTO;
use WorkingCode\Hw12\Exception\ErrorAddInStorageException;
use WorkingCode\Hw12\Exception\NotFoundException;

class RedisService implements StorageInterface
{
    private const INDEX_NAME = 'storage:events';
    private const SIZE_PAGE  = 100;

    public function __construct(private readonly Redis $redis)
    {
    }

    /**
     * @throws RedisException
     * @throws ErrorAddInStorageException
     */
    public function add(EventDTO $eventDTO): void
    {
        $result = $this->redis->zAdd(static::INDEX_NAME, $eventDTO->getPriority(), json_encode($eventDTO));

        if (is_bool($result)) {
            throw new ErrorAddInStorageException(sprintf(
                "%s \n%s",
                'Не удалось добавить в хранилище:',
                print_r($eventDTO->jsonSerialize(), true)
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
     * @param array           $conditions
     * @param EventDTOBuilder $eventDTOBuilder *
     *
     * @return EventDTO
     * @throws JsonException
     * @throws NotFoundException
     * @throws RedisException
     */
    public function findOneByConditions(array $conditions, EventDTOBuilder $eventDTOBuilder): EventDTO
    {
        $eventsCount = $this->redis->zCard(static::INDEX_NAME);
        $foundResult = null;

        for ($i = 0; $i < $eventsCount; $i += static::SIZE_PAGE) {
            $events = $this->redis->zRevRange(static::INDEX_NAME, $i, $i + static::SIZE_PAGE - 1);

            foreach ($events as $event) {
                $event = json_decode($event, true, flags: JSON_THROW_ON_ERROR);

                if (!array_diff_assoc($conditions, $event['conditions'])) {
                    $foundResult = $event;

                    break 2;
                }
            }
        }

        if (!$foundResult) {
            throw new NotFoundException('Запись не найдена');
        }

        return $eventDTOBuilder->buildFromArray($foundResult);
    }
}
