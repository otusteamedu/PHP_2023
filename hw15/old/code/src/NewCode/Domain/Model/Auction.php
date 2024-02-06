<?php

namespace old\code\src\NewCode\Domain\Model;

use old\code\src\NewCode\Domain\ValueObject\Step;
use old\code\src\NewCode\Domain\ValueObject\Title;

class Auction
{
    private int $id;

    public function __construct(
        private Title $title,
        private Step $step
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): Title
    {
        return $this->title;
    }

    public function getStep(): Step
    {
        return $this->step;
    }

    public function setTitle(Title $title): Auction
    {
        $this->title = $title;
        return $this;
    }

    public function setStep(Step $step): Auction
    {
        $this->step = $step;
        return $this;
    }
}
