<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Domain\Model;

use function VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Functions\convertFromIntToString;

class Playlist implements \JsonSerializable, DurationInterface
{
    const FAKE_ID = -1;

    private int $id;
    private string $name;
    private User $user;
    private array $tracksList;

    public function __construct(
        int $id,
        string $name,
        User $user,
        array $tracksList
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->user = $user;
        $this->tracksList = $tracksList;
    }

    public function jsonSerialize(): mixed
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "user" => $this->user->getLogin(),
            "tracksList" => $this->tracksList
        ];
    }

    public function getDuration(): string
    {
        return convertFromIntToString($this->getDurationSeconds());
    }
    public function getDurationSeconds(): int
    {
        $totalDuration = 0;
        foreach ($this->tracksList as $track) {
            $totalDuration += $track->getDurationSeconds();
        }
        return $totalDuration;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getTracksList(): array
    {
        return $this->tracksList;
    }

    public function setTracksList(array $tracksList): self
    {
        $this->tracksList = $tracksList;
        return $this;
    }
}
