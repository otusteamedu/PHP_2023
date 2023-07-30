<?php

namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Model\EventModel;
use IilyukDmitryi\App\Utils\TemplateEngine;
use Throwable;

class EventController
{
    public function addAction()
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            if ($_POST) {
                $channelModel = new EventModel();
                $templateData = $channelModel->add($_POST);
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Event/add.php', $templateData);
        echo $resultHtml;
    }

    public function findAction()
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            if ($_POST) {
                $channelModel = new EventModel();
                $templateData = $channelModel->findTopByParams($_POST);
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Event/find.php', $templateData);
        echo $resultHtml;
    }

    public function listAction()
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $channelModel = new EventModel();
            $templateData = $channelModel->list();
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Event/list.php', $templateData);
        echo $resultHtml;
    }

    public function deleteAction()
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $channelModel = new EventModel();
            $templateData = $channelModel->deleteAll();
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Event/del.php', $templateData);
        echo $resultHtml;
    }
}
