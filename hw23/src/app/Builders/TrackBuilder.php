<?php

declare(strict_types=1);

namespace App\Builders;

use App\Models\Track;

class TrackBuilder
{
    private Track $track;

    public function __construct()
    {
        $this->track = new Track();
    }

    public function build(array $data): Track|array
    {
        $errors = [];

        if (isset($data['title']) && !empty($data['title'])) {
            $this->track->title = $data['title'];
        } else {
            $errors[] = 'Track title is missing';
        }

        if (isset($data['author']) && !empty($data['author'])) {
            $this->track->author = $data['author'];
        }

        if (isset($data['genre']) && !empty($data['genre'])) {
            $this->track->genre = $data['genre'];
        } else {
            $errors[] = 'Track genre is missing';
        }

        if (isset($data['duration']) && !empty($data['duration'])) {
            $this->track->duration = $data['duration'];
        }

        if (isset($data['description']) && !empty($data['description'])) {
            $this->track->description = $data['description'];
        }

        if ($errors) {
            return $errors;
        }
        return $this->track;
    }
}
