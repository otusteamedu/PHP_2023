<?php

namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Model\MovieModel;
use IilyukDmitryi\App\Utils\Helper;
use IilyukDmitryi\App\Utils\TemplateEngine;
use Throwable;

class MovieController
{
    public function deleteAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $movieId = Helper::getIdFromUrl();
            $movieModel = new MovieModel();
            $templateData = $movieModel->deleteMovie($movieId);
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('App/result.php', $templateData);
        echo $resultHtml;
    }

    public function listAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $currCnt = $_GET['items_per_page'] ?? 100;
            $templateData['list'] = (new MovieModel())->getAll($currCnt);
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Movie/list.php', $templateData);
        echo $resultHtml;
    }

    public function updateAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $movieModel = new MovieModel();
            $movieId = Helper::getIdFromUrl();
            $templateData = $movieModel->updateMovie($movieId, $_POST);
        } catch (Throwable $th) {
            $templateData['error'] = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Movie/form.php', $templateData);
        echo $resultHtml;
    }

    public function addAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $movieModel = new MovieModel();
            $templateData = $movieModel->addMovie($_POST);
        } catch (Throwable $th) {
            $templateData['error'] = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Movie/form.php', $templateData);
        echo $resultHtml;
    }
}
