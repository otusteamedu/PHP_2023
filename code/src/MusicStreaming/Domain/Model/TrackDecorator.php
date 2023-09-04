<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Domain\Model;

abstract class TrackDecorator implements TrackInterface, \JsonSerializable
{
    protected TrackInterface $track;

    public function __construct(TrackInterface $track)
    {
        $this->track = $track;
    }

    public function getDurationSeconds(): int
    {
        return $this->track->getDurationSeconds();
    }

    public function getId(): int
    {
        return $this->track->getId();
    }

    public function setId(int $id): TrackInterface
    {
        return $this->track->setId($id);
    }

    public function getName(): string
    {
        return $this->track->getName();
    }

    public function setName(string $name): TrackInterface
    {
        return $this->track->setName($name);
    }

    public function getFileLink(): string
    {
        return $this->track->getFileLink();
    }

    public function setFileLink(string $fileLink): TrackInterface
    {
        return $this->track->setFileLink($fileLink);
    }

    public function getGenre(): Genre
    {
        return $this->track->getGenre();
    }
    public function setGenre(Genre $genre): TrackInterface
    {
        return $this->track->setGenre($genre);
    }

    public function getDuration(): string
    {
        return $this->track->getDuration();
    }

    public function getDescription(): string
    {
        return $this->track->getDescription();
    }

    public function getUser(): User
    {
        return $this->track->getUser();
    }

    public function setUser(User $user): TrackInterface
    {
        return $this->track->setUser($user);
    }

    public function jsonSerialize(): mixed
    {
        $trackSerializeArray = $this->track->jsonSerialize();
        $trackSerializeArray["description"] = $this->getDescription();
        return $trackSerializeArray;
    }
}
