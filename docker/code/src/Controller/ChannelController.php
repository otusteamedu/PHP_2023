<?php

namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Model\ChannelModel;
use IilyukDmitryi\App\Utils\Helper;
use IilyukDmitryi\App\Utils\TemplateEngine;
use Throwable;

class ChannelController
{
    public function deleteAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $channelId = Helper::getIdFromUrl();
            $channelModel = new ChannelModel();
            $templateData = $channelModel->deleteChannel($channelId);
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
            $templateData['list'] = (new ChannelModel())->getAll($currCnt);
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Channel/list.php', $templateData);
        echo $resultHtml;
    }

    public function updateAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $channelModel = new ChannelModel();
            $channelId = Helper::getIdFromUrl();
            $templateData = $channelModel->updateChannel($channelId, $_POST);
        } catch (Throwable $th) {
            $templateData['error'] = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Channel/form.php', $templateData);
        echo $resultHtml;
    }

    public function addAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $channelModel = new ChannelModel();
            $templateData = $channelModel->addChannel($_POST);
        } catch (Throwable $th) {
            $templateData['error'] = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Channel/form.php', $templateData);
        echo $resultHtml;
    }
}
