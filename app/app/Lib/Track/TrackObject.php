<?php

declare(strict_types=1);

namespace App\Lib\Track;

use App\Lib\Audio\CompositeAudioInterface;

class TrackObject implements CompositeAudioInterface
{
    private string $name;
    private string $author;
    private int $genre;
    private int $duration;
    private string $file;

    public function __construct(TrackBuilder $trackBuilder)
    {
        $this->name = $trackBuilder->getName();
        $this->author = $trackBuilder->getAuthor();
        $this->genre = $trackBuilder->getGenre();
        $this->duration = $trackBuilder->getDuration();
        $this->file = $trackBuilder->getFile();
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @return int
     */
    public function getGenre(): int
    {
        return $this->genre;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'author' => $this->author,
            'genre' => $this->genre,
            'duration' => $this->duration,
            'file' => $this->file,
        ];
    }
}
