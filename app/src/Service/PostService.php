<?php

declare(strict_types=1);

namespace App\Service;

use App\Dto\PostDto;
use App\Entity\Collection;
use App\Entity\Post;
use App\Repository\PostMapper;

readonly class PostService
{
    public function __construct(private PostMapper $postMapper)
    {
    }

    public function create(PostDto $postDto): int
    {
        return $this->postMapper->insert($postDto)->getId();
    }

    public function getById(int $id): ?Post
    {
        return $this->postMapper->findById($id);
    }

    public function findAll(): Collection
    {
        return $this->postMapper->findAll();
    }

    public function delete(int $id): void
    {
        $this->postMapper->delete($id);
    }

    public function update(PostDto $postDto): void
    {
        $this->postMapper->update($postDto);
    }
}
