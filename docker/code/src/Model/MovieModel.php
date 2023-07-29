<?php
namespace IilyukDmitryi\App\Model;

use IilyukDmitryi\App\Storage\Base\MovieStorageInterface;
use IilyukDmitryi\App\Storage\StorageApp;

class MovieModel
{
    private ?MovieStorageInterface $storage;

    public function __construct()
    {
        $this->initStorage();
    }

    public function initStorage():void
    {
        $storageApp = StorageApp::get();
        $storage = $storageApp->getMovieStorage();
        $this->storage = $storage;
    }

    /**
     * @param array $movie
     * @return mixed
     */
    public function add(array $movie)
    {
        if(empty($movie['movie_id'])){
            throw new \InvalidArgumentException("Empty key movie_id");
        }
        return $this->storage->add($movie);
    }

    /**
     * @param int $movieId
     * @return mixed
     */
    public function delete(string $movieId)
    {
        if(empty($movieId)){
            throw new \InvalidArgumentException("Empty key movie_id");
        }
        return $this->storage->delete($movieId);
    }

    /**
     * @param int $movieId
     * @param array $movie
     * @return mixed
     */
    public function update(string $movieId, array $movie)
    {
        if(empty($movieId)){
            throw new \InvalidArgumentException("Empty key movie_id");
        }

        return $this->storage->update($movieId,$movie);
    }


    /**
     * @param int $movieId
     * @return array
     */
    public function findById(string $movieId): array
    {
        return $this->storage->findById($movieId);
    }

    /**
     * @param array $filter
     * @return array
     */
    public function find(array $filter): array
    {
        return $this->storage->findBy($filter);
    }

    public function getAll($cnt = 50): array
    {
        $res = $this->storage->find([],$cnt);
        return $res;
    }

    public function getTopPopularChannels(int $cntTop = 10)
    {
        $res = $this->storage->getTopPopularChannels($cntTop);
        return $res;
    }

    public function getLikesDislikesFromChannels(int $cntTop = 10)
    {
        $res = $this->storage->getLikesDislikesFromChannels($cntTop);
        return $res;
    }

}