<?php

declare(strict_types=1);

namespace Imitronov\Hw12\Infrastructure\Http\Event;

use Imitronov\Hw12\Application\Dto\ConditionDto;
use Imitronov\Hw12\Domain\Exception\InvalidArgumentException;
use Imitronov\Hw12\Infrastructure\Http\Request;
use Imitronov\Hw12\Application\UseCase\Event\SearchEventsInput;
use Imitronov\Hw12\Infrastructure\Validator\Event\RequestSearchEventsInputValidator;

final class RequestSearchEventsInput implements SearchEventsInput
{
    public function __construct(
        private readonly Request $request,
        private readonly RequestSearchEventsInputValidator $validator,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function validate(): void
    {
        $this->validator->validate(
            $this->request->get('conditions'),
        );
    }

    public function getConditions(): array
    {
        $conditions = $this->request->get('conditions');
        $dto = [];

        foreach ($conditions as $key => $value) {
            $dto[] = new ConditionDto($key, $value);
        }

        return $dto;
    }
}
