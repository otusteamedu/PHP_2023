<?php

namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Model\DemoModel;
use IilyukDmitryi\App\Utils\TemplateEngine;
use Throwable;

class DemoController
{
    public function installAction(): void
    {
        $templateEngine = new TemplateEngine();
        $templateData = [];
        try {
            $demoModel = new DemoModel();
            if ($demoModel->install()) {
                $templateData['message'] = 'Данные установлены';
            } else {
                $templateData['error'] = 'Данные не установлены';
            }
        } catch (Throwable $th) {
            $templateData['error'] = 'Данные не установлены. Ошибка ' . $th->getMessage();
        }
        $resultHtml = $templateEngine->render('App/result.php', $templateData);
        echo $resultHtml;
    }
}
