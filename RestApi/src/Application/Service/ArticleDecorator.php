<?php

namespace App\Application\Service;

use App\Domain\Entity\TestInterface;

class ArticleDecorator implements TestInterface
{
    private string $text = '';

    public function __construct(private readonly TestInterface $test)
    {
        $this->text = $this->test->getText();
    }

    public function getText(): string
    {
        return $this->text;
    }

    public function setText()
    {
        $this->text .= "<p>Some text</p>";

        $this->test->setText($this->text);
    }
}
