<?php

declare(strict_types=1);

namespace App\Decorators;

use App\Helpers\FormatDurationHelper;
use App\Models\Track;
use Illuminate\Support\Str;

class TrackDescriptionDecorator
{
    private Track $track;

    private string $description;

    private array $socialNetworkLinks = [
        'Spotify' => 'https://spotify.com',
        'Reddit' => 'https://reddit.com',
        'VK Music' => 'https://vk.com/music',
        'Yandex Music' => 'https://music.yandex.ru',
    ];

    public function __construct(Track $track, string $description)
    {
        $this->track = $track;
        $this->description = $description;
    }

    public function decorate(): string
    {
        $this->addDuration();
        $this->addSocialNetworkLinks();

        return $this->description;
    }

    private function addDuration(): void
    {
        if ($this->track->duration) {
            $duration = FormatDurationHelper::formatDuration($this->track->duration);
            $this->description .= PHP_EOL . 'Playback time: ' . $duration;
        }
    }

    private function addSocialNetworkLinks(): void
    {
        if ($this->track->title && $this->track->author) {
            $links = PHP_EOL . 'Share:';

            foreach ($this->socialNetworkLinks as $socialNetwork => $link) {
                $url = [
                    $link,
                    Str::slug(strtolower($this->track->author), '-'),
                    Str::slug($this->track->title, '-')
                ];
                $links .= ' <a href="' . implode('/', $url) . '">On ' . $socialNetwork . '</a>';
            }

            $this->description .= $links;
        }
    }
}
