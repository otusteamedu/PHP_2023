<?php

namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Model\StatistikaModel;

class StatistikaController
{
    public function summaryAction()
    {
        try {
            $currCnt = $_GET['items_per_page'] ?? 100;
            $arrData = (new StatistikaModel())->getLikesDislikesFromChannels($currCnt);
            $viewPath = $_SERVER['DOCUMENT_ROOT'] . '/src/View/Statistika/summary.php';
            include $viewPath;
        } catch (\Throwable $th) {
            echo '<pre>' . print_r([$th], 1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete
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
        } catch (\Throwable $th) {
            echo '<pre>' . print_r([$th], 1) . '</pre>' . __FILE__ . ' # ' . __LINE__;//test_delete
            $resultHtml = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
    }
}