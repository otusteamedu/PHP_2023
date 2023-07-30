<?php

namespace IilyukDmitryi\App\Model;

use Exception;
use IilyukDmitryi\App\Storage\Base\MovieStorageInterface;
use IilyukDmitryi\App\Storage\StorageApp;
use IilyukDmitryi\App\Utils\Helper;
use InvalidArgumentException;
use Throwable;

class MovieModel
{
    private ?MovieStorageInterface $storage;

    public function __construct()
    {
        $this->initStorage();
    }

    public function initStorage(): void
    {
        $storageApp = StorageApp::get();
        $storage = $storageApp->getMovieStorage();
        $this->storage = $storage;
    }

    public function updateMovie($movieId, $arData): array
    {
        $templateData = [];
        try {
            if (!$movieId) {
                throw new Exception('Пустой ID');
            }
            $movie = $this->findById($movieId);
            if (!$movie) {
                throw new Exception('Не найдено видео с таким  ID');
            }
            if ($arData) {
                $moviePost = [
                    'movie_name' => Helper::sanitize($arData["movie_name"]),
                    'channel_id' => Helper::sanitize($arData["channel_id"]),
                    'movie_description' => Helper::sanitize($arData["movie_description"]),
                    'like' => (int)Helper::sanitize($arData["like"]),
                    'dislike' => (int)Helper::sanitize($arData["dislike"]),
                    'duration' => (int)Helper::sanitize($arData["duration"]),
                ];
                if (!$this->update($movieId, $moviePost)) {
                    $templateData['error'] = 'Ошибка обновления';
                } else {
                    $templateData['message'] = 'Успешное обновление';
                    $movie['movie_name'] = $moviePost['movie_name'];
                    $movie['channel_id'] = $moviePost['channel_id'];
                    $movie['movie_description'] = $moviePost['movie_description'];
                    $movie['like'] = $moviePost['like'];
                    $movie['dislike'] = $moviePost['dislike'];
                    $movie['duration'] = $moviePost['duration'];
                }
            }
            $movie['id'] = $movieId;
            $templateData['formData'] = $movie;
            $templateData['formType'] = 'update';
        } catch (Throwable $th) {
            $templateData['error'] = 'Данные не обновлены. Ошибка ' . $th->getMessage();
        }
        return $templateData;
    }

    /**
     * @param string $movieId
     * @return array
     */
    protected function findById(string $movieId): array
    {
        return $this->storage->findById($movieId);
    }

    /**
     * @param string $movieId
     * @param array $movie
     * @return mixed
     */
    protected function update(string $movieId, array $movie): mixed
    {
        if (empty($movieId)) {
            throw new InvalidArgumentException("Empty key movie_id");
        }

        return $this->storage->update($movieId, $movie);
    }

    public function deleteMovie($movieId): array
    {
        $templateData = [];
        $movieId = Helper::getIdFromUrl();
        if (!$movieId) {
            throw new Exception('Пустой ID');
        }
        $res = $this->findById($movieId);
        if (!$res) {
            throw new Exception('Не найдено видео с таким  ID');
        }
        $res = $this->delete($movieId);
        if ($res) {
            $templateData['message'] = 'Видео успешно удалено ' . $movieId;
        } else {
            $templateData['error'] = 'Ошибка удаления видео ' . $movieId;
        }
        return $templateData;
    }

    /**
     * @param string $movieId
     * @return mixed
     */
    protected function delete(string $movieId): mixed
    {
        if (empty($movieId)) {
            throw new InvalidArgumentException("Empty key movie_id");
        }
        return $this->storage->delete($movieId);
    }

    public function addMovie(array $arrData): array
    {
        $templateData['formData'] = [
            'movie_id' => '',
            'movie_name' => '',
            'channel_id' => '',
            'movie_description' => '',
            'like' => '',
            'dislike' => '',
            'duration' => '',
        ];
        try {
            if ($arrData) {
                $moviePost = [
                    'movie_id' => Helper::sanitize($arrData["movie_id"]),
                    'channel_id' => Helper::sanitize($arrData["channel_id"]),
                    'movie_name' => Helper::sanitize($arrData["movie_name"]),
                    'movie_description' => Helper::sanitize($arrData["movie_description"]),
                    'like' => (int)Helper::sanitize($arrData["like"]),
                    'dislike' => (int)Helper::sanitize($arrData["dislike"]),
                    'duration' => (int)Helper::sanitize($arrData["duration"]),
                ];

                $movieId = $moviePost['movie_id'];
                $moviePost['id'] = $movieId;
                if (!$movieId) {
                    throw new Exception('Пустой ID');
                }
                $movie = $this->findById($movieId);
                if ($movie) {
                    $templateData['error'] = 'Найдено видео с таким  ID';
                } elseif (!$this->add($moviePost)) {
                    $templateData['error'] = 'Ошибка добавления видео';
                } else {
                    $templateData['message'] = 'Успешное добавление';
                }

                $templateData['formData'] = $moviePost;
                $templateData['formType'] = 'add';
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка удаления видео ' . $th->getMessage();
        }
        return $templateData;
    }

    /**
     * @param array $movie
     * @return bool
     */
    protected function add(array $movie): mixed
    {
        if (empty($movie['movie_id'])) {
            throw new InvalidArgumentException("Empty key movie_id");
        }
        return $this->storage->add($movie);
    }

    public function getAll($cnt = 50): array
    {
        $res = $this->storage->find([], $cnt);
        return $res;
    }

    /**
     * @param array $filter
     * @return array
     */
    public function find(array $filter): array
    {
        return $this->storage->find($filter);
    }

    public function getTopPopularChannels(int $cntTop = 10): array
    {
        $res = $this->storage->getTopPopularChannels($cntTop);
        return $res;
    }

    public function getLikesDislikesFromChannels(int $cntTop = 10): array
    {
        $res = $this->storage->getLikesDislikesFromChannels($cntTop);
        return $res;
    }
}
