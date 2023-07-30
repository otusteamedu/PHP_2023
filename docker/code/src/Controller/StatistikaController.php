<?php

namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Model\StatistikaModel;
use IilyukDmitryi\App\Utils\TemplateEngine;
use Throwable;

class StatistikaController
{
    public function summaryAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $currCnt = $_GET['items_per_page'] ?? 100;
            $templateData['list'] = (new StatistikaModel())->getLikesDislikesFromChannels($currCnt);
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Statistika/summary.php', $templateData);
        echo $resultHtml;
    }

    public function topAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $currCntTop = $_GET['items_per_page'] ?? 5;
            $templateData['list'] = (new StatistikaModel())->getTopPopularChannels($currCntTop);
        } catch (Throwable $th) {
            $templateData['error'] = 'Ошибка: ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('Statistika/top.php', $templateData);
        echo $resultHtml;
    }
}
