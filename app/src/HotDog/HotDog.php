<?php

declare(strict_types=1);

namespace Root\App\HotDog;

class HotDog
{
    protected int $sauce = 0;
    protected int $mustard = 0;
    protected string $name = 'HotDog';

    public function __construct(int $sauce, int $mustard)
    {
        $this->sauce = $sauce;
        $this->mustard = $mustard;
    }
    public function getSauce(): int
    {
        return $this->sauce;
    }
    public function getMustard(): int
    {
        return $this->mustard;
    }
    public function getName(): string
    {
        return $this->name;
    }
}
