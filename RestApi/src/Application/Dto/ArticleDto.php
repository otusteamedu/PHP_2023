<?php

namespace App\Application\Dto;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

class ArticleDto
{
    private string $name;
    #[Context([DateTimeNormalizer::FORMAT_KEY => "Y-m-d H:i:s"])]
    private DateTimeInterface $creationDate;
    private int $authorId;
    private int $categoryId;
    private string $text;

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
     * @return DateTimeInterface
     */
    public function getCreationDate(): DateTimeInterface
    {
        return $this->creationDate;
    }

    /**
     * @param DateTimeInterface $creationDate
     */
    public function setCreationDate(DateTimeInterface $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return int
     */
    public function getAuthorId(): int
    {
        return $this->authorId;
    }

    /**
     * @param int $authorId
     */
    public function setAuthorId(int $authorId): void
    {
        $this->authorId = $authorId;
    }

    /**
     * @return int
     */
    public function getCategoryId(): int
    {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     */
    public function setCategoryId(int $categoryId): void
    {
        $this->categoryId = $categoryId;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param string $text
     */
    public function setText(string $text): void
    {
        $this->text = $text;
    }
}
