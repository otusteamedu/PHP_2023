<?php

declare(strict_types=1);

namespace AYamaliev\hw13\Application\Dto;

class NewsDto
{
    private string $title;
    private string $text;
    private string $image;
    private string $created_at;

    public function __construct(array $arguments)
    {
        foreach ($arguments as $argument) {
            [$argumentName, $argumentValue] = explode('=', $argument);

            switch ($argumentName) {
                case '--title':
                    $this->title = $argumentValue;
                    break;
                case '--text':
                    $this->text = $argumentValue;
                    break;
                case '--image':
                    $this->image = $argumentValue;
                    break;
                case '--created_at':
                    $this->created_at = $argumentValue;
                    break;
            }
        }
    }
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function getImage(): string
    {
        return $this->image;
    }

    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
}
