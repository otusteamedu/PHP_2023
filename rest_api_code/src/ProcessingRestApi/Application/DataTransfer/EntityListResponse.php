<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw20\ProcessingRestApi\Application\DataTransfer;

use function VKorabelnikov\Hw20\ProcessingRestApi\Domain\Model\Functions\convertFromIntToString;

class EntityListResponse extends Response
{
    protected string $duration;
    protected array $entitiesList;

    public function __construct(array $entitiesList)
    {
        $this->success = true;
        $this->entitiesList = $entitiesList;
        $this->duration = $this->computeDuration($entitiesList);
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function getEntitiesList(): array
    {
        return $this->entitiesList;
    }

    private function computeDuration(array $entitiesList): string
    {
        $totalDuration = 0;
        foreach ($entitiesList as $entity) {
            $totalDuration += $entity->getDurationSeconds();
        }
        return convertFromIntToString($totalDuration);
    }

    public function jsonSerialize(): mixed
    {
        return [
            "success" => $this->success,
            "duration" => $this->duration,
            "entitiesList" => $this->entitiesList
        ];
    }
}
