<?php

namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Model\EventModel;
use IilyukDmitryi\App\Utils\Helper;
use IilyukDmitryi\App\Utils\TemplateEngine;
use Throwable;

class EventController
{
    public function addAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            if ($_POST) {
                $eventModel = new EventModel();
                $templateData = $eventModel->add($_POST);
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }
        $storageName = Helper::getStorageName();
        $templateData['TITLE'] = $storageName.' - добавление события';
        $resultHtml = $templateEngine->render('Event/add.php', $templateData);
        echo $resultHtml;
    }
    
    public function findAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            if ($_POST) {
                $channelModel = new EventModel();
                $templateData = $channelModel->findTopByParams($_POST);
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }
        $storageName = Helper::getStorageName();
        $templateData['TITLE'] = $storageName.' - поиск события';
        $resultHtml = $templateEngine->render('Event/find.php', $templateData);
        echo $resultHtml;
    }
    
    public function listAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $channelModel = new EventModel();
            $templateData = $channelModel->list();
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }
        $storageName = Helper::getStorageName();
        $templateData['TITLE'] = $storageName.' - список всех событий';
        $resultHtml = $templateEngine->render('Event/list.php', $templateData);
        echo $resultHtml;
    }
    
    public function deleteAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $channelModel = new EventModel();
            $templateData = $channelModel->deleteAll();
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: '.$th->getMessage();
        }
        $storageName = Helper::getStorageName();
        $templateData['TITLE'] = $storageName.' - удаление всех записей';
        $resultHtml = $templateEngine->render('Event/del.php', $templateData);
        echo $resultHtml;
    }
}
