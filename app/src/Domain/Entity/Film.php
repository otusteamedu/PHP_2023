<?php

declare(strict_types=1);

namespace Yevgen87\App\Domain\Entity;

use Yevgen87\App\Domain\ValueObjects\Description;
use Yevgen87\App\Domain\ValueObjects\Title;
use Yevgen87\App\Domain\ValueObjects\Url;

class Film
{
    /**
     * @var integer|null
     */
    private ?int $id;

    /**
     * @var Title
     */
    private Title $title;

    /**
     * @var Description
     */
    private Description $description;

    /**
     * @var Url
     */
    private Url $image_preview;

    /**
     * @var Url
     */
    private Url $teaser_preview;

    public function __construct(
        int|null $id,
        Title $title,
        Description $description,
        Url $image_preview,
        Url $teaser_preview
    ) {
        $this->id = $id;
        $this->title = $title;
        $this->description = $description;
        $this->image_preview = $image_preview;
        $this->teaser_preview = $teaser_preview;
    }

    public function getId()
    {
        return $this->id;
    }
    public function getTitle()
    {
        return $this->title->getValue();
    }
    public function getDescription()
    {
        return $this->description->getValue();
    }
    public function getImagePreview()
    {
        return $this->image_preview->getValue();
    }
    public function getTeaserPreview()
    {
        return $this->teaser_preview->getValue();
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'title' => $this->getTitle(),
            'description' => $this->getDescription(),
            'image_preview' => $this->getImagePreview(),
            'teaser_preview' => $this->getTeaserPreview()
        ];
    }
}
