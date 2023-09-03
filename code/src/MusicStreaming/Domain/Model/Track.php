<?php

declare(strict_types=1);

namespace VKorabelnikov\Hw16\MusicStreaming\Domain\Model;

use function VKorabelnikov\Hw16\MusicStreaming\Domain\Model\Functions\convertFromStringToInt;

class Track implements \JsonSerializable, DurationInterface, TrackInterface
{
    const FAKE_ID = -1;


    private int $id;
    private string $name;
    private string $author;
    private Genre $genre;
    private string $duration;
    private string $description;
    private string $fileLink;
    private User $user;

    public function __construct(
        int $id,
        string $name,
        string $author,
        Genre $genre,
        string $duration,
        string $description,
        string $fileLink,
        User $user
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->author = $author;
        $this->genre = $genre;
        $this->duration = $duration;
        $this->description = $description;
        $this->fileLink = $fileLink;
        $this->user = $user;
    }

    public function getDurationSeconds(): int
    {
        return convertFromStringToInt($this->duration);
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getAuthor(): string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;
        return $this;
    }

    public function getFileLink(): string
    {
        return $this->fileLink;
    }

    public function setFileLink(string $fileLink): self
    {
        $this->fileLink = $fileLink;
        return $this;
    }

    public function getGenre(): Genre
    {
        return $this->genre;
    }

    public function setGenre(Genre $genre): self
    {
        $this->genre = $genre;
        return $this;
    }

    public function getDuration(): string
    {
        return $this->duration;
    }

    public function setDuration(string $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
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

    public function jsonSerialize(): mixed
    {
        return [
            "name" => $this->name,
            "author" => $this->author,
            "genre" => $this->genre->getName(),
            "duration" => $this->duration,
            "description" => $this->description,
            "fileLink" => $this->linkToDownload(),
            "user" => $this->user->getLogin()
        ];
    }

    protected function linkToDownload(): string
    {
        $filePathParts = explode("/", $this->fileLink);
        $partsCount = count($filePathParts);
        if ($partsCount >= 2) {
            return "/" . $filePathParts[$partsCount - 2] . "/" . $filePathParts[$partsCount - 1];
        } else {
            return "";
        }
    }
}
