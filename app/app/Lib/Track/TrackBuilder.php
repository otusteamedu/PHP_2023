<?php

declare(strict_types=1);

namespace App\Lib\Track;

class TrackBuilder
{
    private string $name;
    private string $author;
    private int $genre;
    private int $duration;
    private string $file;

    public function __construct(
        string $name,
        string $author,
        int    $genre,
        int    $duration,
        string $file
    )
    {
        $this->name = $name;
        $this->author = $author;
        $this->genre = $genre;
        $this->duration = $duration;
        $this->file = $file;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getAuthor(): string
    {
        return $this->author;
    }

    /**
     * @param string $author
     */
    public function setAuthor(string $author): void
    {
        $this->author = $author;
    }

    /**
     * @return int
     */
    public function getGenre(): int
    {
        return $this->genre;
    }

    /**
     * @param int $genre
     */
    public function setGenre(int $genre): void
    {
        $this->genre = $genre;
    }

    /**
     * @return int
     */
    public function getDuration(): int
    {
        return $this->duration;
    }

    /**
     * @param int $duration
     */
    public function setDuration(int $duration): void
    {
        $this->duration = $duration;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }

    /**
     * @param string $file
     */
    public function setFile(string $file): void
    {
        $this->file = $file;
    }

    public function build(): TrackObject
    {
        return new TrackObject($this);
    }
}
