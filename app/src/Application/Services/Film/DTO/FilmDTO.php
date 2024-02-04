<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\Services\Film\DTO;

class FilmDTO
{
    public string $title;

    public string $description;

    public string $image_preview;

    public string $teaser_preview;

    public function __construct(
        $title,
        $description,
        $image_preview,
        $teaser_preview
    ) {
        $this->title = $title;
        $this->description = $description;
        $this->image_preview = $image_preview;
        $this->teaser_preview = $teaser_preview;
    }
}
