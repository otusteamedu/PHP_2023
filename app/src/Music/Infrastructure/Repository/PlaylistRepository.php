<?php

declare(strict_types=1);

namespace App\Music\Infrastructure\Repository;

use App\Music\Application\Iterator\UploadIteratorInterface;
use App\Music\Domain\Entity\Playlist;
use App\Music\Domain\RepositoryInterface\PlaylistRepositoryInterface;
use App\Music\Domain\RepositoryInterface\UploadCollectionInterface;
use App\Music\Domain\RepositoryInterface\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PlaylistRepository extends ServiceEntityRepository implements PlaylistRepositoryInterface, UploadCollectionInterface
{
    public function __construct(
        ManagerRegistry $registry,
        private UserRepositoryInterface $userRepository
    ) {
        parent::__construct($registry, Playlist::class);
    }

    public function uploadCollection(UploadIteratorInterface $iterator)
    {
        while ($iterator->hasMore()) {
            $uploadItem = $iterator->getNext();
            $playlist = new Playlist(
                $uploadItem['name'],
                $this->userRepository->findById($uploadItem['user_id'])
            );
            $this->_em->persist($playlist);
        }
        $this->_em->flush();
    }
}