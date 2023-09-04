<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Domain\Model;

interface TrackInterface
{
    public function getDurationSeconds(): int;
    public function getId(): int;
    public function setId(int $id): self;
    public function getName(): string;
    public function setName(string $name): self;
    public function getFileLink(): string;
    public function setFileLink(string $fileLink): self;
    public function getGenre(): Genre;
    public function setGenre(Genre $genre): self;
    public function getDuration(): string;
    public function getDescription(): string;
    public function getUser(): User;
    public function setUser(User $user): self;
    public function jsonSerialize(): mixed;
}
