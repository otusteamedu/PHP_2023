<?php

declare(strict_types=1);

namespace Art\DataMapper\Domain\Models;

final class LessonCollection
{
    private array $items = [];

    /**
     * @param Lesson $lesson
     * @return $this
     */
    public function add(Lesson $lesson): self
    {
        $this->items[] = $lesson;
        return $this;
    }

    /**
     * @return Lesson[]
     */
    public function getItems(): array
    {
        return $this->items;
    }
}
