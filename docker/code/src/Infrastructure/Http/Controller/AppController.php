<?php

namespace IilyukDmitryi\App\Infrastructure\Http\Controller;

use IilyukDmitryi\App\Infrastructure\Http\Utils\Helper;
use IilyukDmitryi\App\Infrastructure\Http\Utils\TemplateEngine;

class AppController
{
    public function indexAction(): void
    {
        $templateEngine = new TemplateEngine();
        $storageName = Helper::getStorageName();
        $resultHtml = $templateEngine->render('App/index.php', ['TITLE' => $storageName]);
        echo $resultHtml;
    }
}
