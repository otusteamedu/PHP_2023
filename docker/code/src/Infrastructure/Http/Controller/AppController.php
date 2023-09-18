<?php

namespace IilyukDmitryi\App\Infrastructure\Http\Controller;

use IilyukDmitryi\App\Infrastructure\Http\Utils\TemplateEngine;

class AppController
{
    public function indexAction(): void
    {
        $templateEngine = new TemplateEngine();

        $resultHtml = $templateEngine->render('App/index.php', ['TITLE' => 'Работас брокером сообщений']);
        echo $resultHtml;
    }
}
