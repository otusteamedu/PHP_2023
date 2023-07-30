<?php

namespace IilyukDmitryi\App\Controller;

use Exception;
use IilyukDmitryi\App\Model\MovieModel;
use Throwable;

class UserEventController
{
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
}
