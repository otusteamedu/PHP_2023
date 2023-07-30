<?php

namespace IilyukDmitryi\App\Controller;

use IilyukDmitryi\App\Utils\Helper;
use IilyukDmitryi\App\Utils\TemplateEngine;

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
