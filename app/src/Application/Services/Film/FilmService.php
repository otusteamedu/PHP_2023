<?php

declare(strict_types=1);

namespace Yevgen87\App\Application\Services\Film;

use Yevgen87\App\Application\Services\Film\DTO\FilmDTO;
use Yevgen87\App\Application\Services\Film\DTO\IndexDTO;
use Yevgen87\App\Domain\Repositories\FilmRepositoryInterface;
use Yevgen87\App\Domain\Entity\Film as EntityFilm;
use Yevgen87\App\Domain\ValueObjects\Description;
use Yevgen87\App\Domain\ValueObjects\Title;
use Yevgen87\App\Domain\ValueObjects\Url;

class FilmService
{
    public function __construct(private FilmRepositoryInterface $filmRepository)
    {
    }

    public function findAll(IndexDTO $dto)
    {
        return $this->filmRepository->select($dto->toArray());
    }

    public function store(FilmDTO $dto)
    {
        $entity = new EntityFilm(
            null,
            new Title($dto->title),
            new Description($dto->description),
            new Url($dto->image_preview),
            new Url($dto->teaser_preview)
        );

        return $this->filmRepository->insert($entity);
    }

    public function getById(int $id)
    {
        return $this->filmRepository->fetchById($id);
    }

    public function update(int $id, FilmDTO $dto)
    {
        $entity = new EntityFilm(
            $id,
            new Title($dto->title),
            new Description($dto->description),
            new Url($dto->image_preview),
            new Url($dto->teaser_preview)
        );

        return $this->filmRepository->update($id, $entity);
    }

    public function delete(int $id)
    {
        return $this->filmRepository->delete($id);
    }
}
