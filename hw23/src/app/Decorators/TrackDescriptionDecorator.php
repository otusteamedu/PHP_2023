<?php

declare(strict_types=1);

namespace App\Decorators;

use App\Composites\DescriptionComponent;
use App\Helpers\FormatDurationHelper;
use Illuminate\Support\Str;

class TrackDescriptionDecorator
{
    private DescriptionComponent $track;

    private string|null $description;

    private array $socialNetworkLinks = [
        'Spotify' => 'https://spotify.com',
        'Reddit' => 'https://reddit.com',
        'VK Music' => 'https://vk.com/music',
        'Yandex Music' => 'https://music.yandex.ru',
    ];

    public function __construct(DescriptionComponent $track, string $description = null)
    {
        $this->track = $track;
        $this->description = $description;
    }

    public function decorate(bool $full = true): string
    {
        $this->addDuration();

        if ($full) {
            $this->addSocialNetworkLinks();
        }

        return $this->description;
    }

    private function addDuration(): void
    {
        if ($this->track->duration) {
            $duration = FormatDurationHelper::formatDuration($this->track->duration);
            $description = 'Playback time: ' . $duration;

            if (!empty($this->description)) {
                $this->description .= PHP_EOL . $description;
            } else {
                $this->description = $description;
            }
        }
    }

    private function addSocialNetworkLinks(): void
    {
        if ($this->track->title && $this->track->author) {
            $links = 'Share:';

            foreach ($this->socialNetworkLinks as $socialNetwork => $link) {
                $url = [
                    $link,
                    Str::slug(strtolower($this->track->author), '-'),
                    Str::slug($this->track->title, '-')
                ];
                $links .= ' <a href="' . implode('/', $url) . '">On ' . $socialNetwork . '</a>';
            }

            if (!empty($this->description)) {
                $this->description .= PHP_EOL . $links;
            } else {
                $this->description = $links;
            }
        }
    }
}
