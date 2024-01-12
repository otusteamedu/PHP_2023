<?php

namespace App\Application\Service;

use App\Domain\Entity\Contract\DecoratorInterface;

class ArticleDecorator implements DecoratorInterface
{
    private string $text = '';

    public function __construct(private readonly DecoratorInterface $article, int $readingTime)
    {
        $this->text = $this->article->getText() . "<p>Reading time: {$readingTime} minutes</p>";
        $this->setText($this->text);
    }

    public function getText(): string
    {
        return $this->article->getText();
    }

    public function setText(string $text): static
    {
        $this->article->setText($text);

        return $this;
    }
}
