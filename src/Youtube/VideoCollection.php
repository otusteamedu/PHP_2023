<?php

declare(strict_types=1);

namespace Otus\App\Youtube;

use Otus\App\Elastic\Client;
use Otus\App\Youtube\Entity\Video;
use Otus\App\Youtube\Normalizer\VideoNormalizer;

final readonly class VideoCollection
{
    public function __construct(
        private Client $client,
        private VideoNormalizer $normalizer,
        private string $index,
    ) {
    }

    public function add(Video $video): void
    {
        $this->client->addDoc($this->index, $this->normalizer->normalize($video));
    }

    public function delete(string $id): void
    {
        $this->client->deleteDoc($this->index, $id);
    }
}