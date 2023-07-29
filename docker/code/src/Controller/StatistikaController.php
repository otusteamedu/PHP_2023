<?php

namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Model\StatistikaModel;
use Throwable;

class StatistikaController
{
    public function summaryAction()
    {
        try {
            $currCnt = $_GET['items_per_page'] ?? 100;
            $arrData = (new StatistikaModel())->getLikesDislikesFromChannels($currCnt);
            $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/Statistika/summary.php';
            include $viewPath;
        } catch (Throwable $th) {
            $resultHtml = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
    }

    public function topAction()
    {
        try {
            $currCntTop = $_GET['items_per_page'] ?? 5;
            $arrData = (new StatistikaModel())->getTopPopularChannels($currCntTop);
            $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/Statistika/top.php';
            include $viewPath;
        } catch (Throwable $th) {
            $resultHtml = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
    }
}
