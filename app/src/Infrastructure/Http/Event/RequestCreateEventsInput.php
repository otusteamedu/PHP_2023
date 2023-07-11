<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Infrastructure\Http\Event;

use Imitronov\Hw12\Application\Dto\ConditionDto;
use Imitronov\Hw12\Application\Dto\EventDataDto;
use Imitronov\Hw12\Application\Dto\EventDto;
use Imitronov\Hw12\Domain\Exception\InvalidArgumentException;
use Imitronov\Hw12\Infrastructure\Http\Request;
use Imitronov\Hw12\Application\UseCase\Event\CreateEventsInput;
use Imitronov\Hw12\Infrastructure\Validator\Event\RequestCreateEventsInputValidator;

final class RequestCreateEventsInput implements CreateEventsInput
{
    public function __construct(
        private readonly Request $request,
        private readonly RequestCreateEventsInputValidator $validator,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        foreach ($this->request->get('events') as $event) {
            $this->validator->validate(
                array_key_exists('priority', $event) ? $event['priority'] : null,
                array_key_exists('conditions', $event) ? $event['conditions'] : null,
                array_key_exists('event', $event) ? $event['event'] : null,
            );
        }
    }

    /**
     * @return EventDto[]
     */
    public function getEvents(): iterable
    {
        foreach ($this->request->get('events') as $event) {
            yield new EventDto(
                $event['priority'],
                array_map(
                    static fn ($key, $value) => new ConditionDto($key, $value),
                    array_keys($event['conditions']),
                    array_values($event['conditions']),
                ),
                new EventDataDto(
                    $event['event']['type'],
                    $event['event']['name'],
                    new \DateTimeImmutable($event['event']['dateTime']),
                ),
            );
        }
    }
}
