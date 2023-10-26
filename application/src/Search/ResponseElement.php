<?php

namespace Gesparo\ES\Search;

class ResponseElement
{
    private string $index;
    private string $id;
    private float $score;
    private array $source;

    public function __construct(string $index, string $id, float $score, array $source)
    {
        $this->index = $index;
        $this->id = $id;
        $this->score = $score;
        $this->source = $source;
    }

    public function getIndex(): string
    {
        return $this->index;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getScore(): float
    {
        return $this->score;
    }

    public function getSource(): array
    {
        return $this->source;
    }

    public function getTitle()
    {
        return $this->source['title'];
    }

    public function getPrice()
    {
        return $this->source['price'];
    }
}