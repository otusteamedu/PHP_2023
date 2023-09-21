<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Repository;

use App\Music\Application\Iterator\UploadIteratorInterface;
use App\Music\Domain\Entity\Track;
use App\Music\Domain\RepositoryInterface\GenreRepositoryInterface;
use App\Music\Domain\RepositoryInterface\TrackRepositoryInterface;
use App\Music\Domain\RepositoryInterface\UploadCollectionInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class TrackRepository extends ServiceEntityRepository implements TrackRepositoryInterface, UploadCollectionInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private readonly GenreRepositoryInterface $genreRepository
    ) {
        parent::__construct($registry, Track::class);
    }


    public function add(Track $track): void
    {
        $this->_em->persist($track);
        $this->_em->flush();
    }

    public function findById(int $id): ?Track
    {
        return $this->find($id);
    }

    public function uploadCollection(UploadIteratorInterface $iterator)
    {
        while ($iterator->hasMore()) {
            $uploadItem = $iterator->getNext();
            $track = new Track(
                $uploadItem['name'],
                $uploadItem['author'],
                $uploadItem['duration'],
                $this->genreRepository->findById($uploadItem['genre_id'])
            );
            $this->_em->persist($track);
        }
        $this->_em->flush();
    }
}