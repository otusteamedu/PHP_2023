<?php

namespace App\Application\action\titleSearch;

use App\Application\action\CriteriaInterface;

class TitleCriteria implements CriteriaInterface
{
    private string $title;

    public function __construct(array $args)
    {
        $this->title = $args[1];
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
