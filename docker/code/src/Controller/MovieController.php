<?php


namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Model\MovieModel;
use Exception;
use Throwable;

class MovieController
{
    public static function getMovieIdFromUrl(): string
    {
        $segments = explode('/', $_SERVER['REQUEST_URI']);
        $movieId = $segments[count($segments) - 2] ?? '';
        return $movieId;
    }

    public function deleteAction()
    {
        try {
            $movieId = static::getMovieIdFromUrl();
            if (!$movieId) {
                throw new Exception('Пустой ID');
            }
            $movieModel = new MovieModel();
            $res = $movieModel->findById($movieId);
            if (!$res) {
                throw new Exception('Не найдено видео с таким  ID');
            }
            $res = $movieModel->delete($movieId);
        } catch (Throwable $th) {
            $resultHtml = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }

        $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/App/index.php';
        include $viewPath;
    }

    public function listAction()
    {
        try {
            $currCnt = $_GET['items_per_page'] ?? 100;
            $arrData = (new MovieModel())->getAll($currCnt);
            $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/Movie/list.php';
            include $viewPath;
        } catch (Throwable $th) {
            $resultHtml = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
    }

    public function updateAction()
    {
        try {
            $movieId = static::getMovieIdFromUrl();
            if (!$movieId) {
                throw new Exception('Пустой ID');
            }
            $movieModel = new MovieModel();
            $movie = $movieModel->findById($movieId);
            if (!$movie) {
                throw new Exception('Не найдено видео с таким  ID');
            }
            if ($_POST) {
                $moviePost = [
                    //'movie_id' => static::sanitize($_POST["movie_id"]),
                    'movie_name' => static::sanitize($_POST["movie_name"]),
                    'channel_id' => static::sanitize($_POST["channel_id"]),
                    'movie_description' => static::sanitize($_POST["movie_description"]),
                    'like' => (int)static::sanitize($_POST["like"]),
                    'dislike' => (int)static::sanitize($_POST["dislike"]),
                    'duration' => (int)static::sanitize($_POST["duration"]),
                ];
                if (!$movieModel->update($movieId, $moviePost)) {
                    $arrResult['error'] = 'Ошибка обновления';
                } else {
                    $arrResult['message'] = 'Успешное обновление';
                    $movie['movie_name'] = $moviePost['movie_name'];
                    $movie['channel_id'] = $moviePost['channel_id'];
                    $movie['movie_description'] = $moviePost['movie_description'];
                    $movie['like'] = $moviePost['like'];
                    $movie['dislike'] = $moviePost['dislike'];
                    $movie['duration'] = $moviePost['duration'];
                }
            }
            $movie['id'] = $movieId;
            $arrResult['formData'] = $movie;
            $arrResult['formType'] = 'update';
            $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/Movie/form.php';
            include $viewPath;
        } catch (Throwable $th) {
            $resultHtml = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
    }

    public function addAction()
    {
        try {
            $arrResult['formData'] = [
                'movie_id' =>'',
                'movie_name' =>'',
                'channel_id' =>'',
                'movie_description' =>'',
                'like' =>'',
                'dislike' => '',
                'duration' => '',
            ];
            if ($_POST) {
                $moviePost = [
                    'movie_id' => static::sanitize($_POST["movie_id"]),
                    'channel_id' => static::sanitize($_POST["channel_id"]),
                    'movie_name' => static::sanitize($_POST["movie_name"]),
                    'movie_description' => static::sanitize($_POST["movie_description"]),
                    'like' => (int)static::sanitize($_POST["like"]),
                    'dislike' => (int)static::sanitize($_POST["dislike"]),
                    'duration' => (int)static::sanitize($_POST["duration"]),
                ];

                $movieId = $moviePost['movie_id'];
                $moviePost['id'] = $movieId;
                if (!$movieId) {
                    throw new Exception('Пустой ID');
                }
                $movieModel = new MovieModel();
                $movie = $movieModel->findById($movieId);
                if ($movie) {
                    $arrResult['error'] = 'Найдено видео с таким  ID';
                } elseif (!$movieModel->add($moviePost)) {
                    $arrResult['error'] = 'Ошибка добавления видео';
                } else {
                    $arrResult['message'] = 'Успешное добавление';
                }

                $arrResult['formData'] = $moviePost;
                $arrResult['formType'] = 'add';
            }

            $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/Movie/form.php';
            include $viewPath;
        } catch (Throwable $th) {
            $resultHtml = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
    }

    public static function sanitize($data)
    {
        return htmlspecialchars(trim($data));
    }
}